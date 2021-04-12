<?php

namespace App\MessageHandler;

use App\Dto\Change;
use App\Dto\Events\EventDescriptor;
use App\Dto\Events\PageContentChangedEventDetails;
use App\Entity\ScriptOutput;
use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
use App\Events\PageContentChanged;
use App\Message\SaveEvent;
use App\Message\TaskChanged;
use App\Message\TaskExecutionMessage;
use App\Message\TaskFailed;
use App\ScriptExecution\ScriptExecutionFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ExecuteTask implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    private MessageBusInterface $bus;

    private ScriptExecutionFactory $scriptExecutionFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        MessageBusInterface $bus,
        ScriptExecutionFactory $scriptExecutionFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->bus = $bus;
        $this->scriptExecutionFactory = $scriptExecutionFactory;
    }

    /**
     * @param TaskExecutionMessage $taskExecutionMessage
     */
    public function __invoke(TaskExecutionMessage $taskExecutionMessage)
    {
        /** @var Task $task */
        $task = $this->entityManager->getRepository(Task::class)
            ->find($taskExecutionMessage->getTaskId());

        $scripts = $task->getScripts();

        $executionHistory = new TaskExecutionHistory();
        $executionHistory->setTask($task);

        $task->finish();

        $this->entityManager->persist($task);
        $this->entityManager->persist($executionHistory);
        $this->entityManager->flush();

        $changes = [];

        foreach ($scripts as $script) {
            /** @var ScriptOutput|null $previousOutput */
            $previousOutput = $this->entityManager
                ->getRepository(ScriptOutput::class)
                ->findPrevious($script);

            $output = new ScriptOutput();
            $output->setExecutionHistory($executionHistory);
            $output->setScript($script);

            $newOutput = null;

            try {
                $newOutput = $this->scriptExecutionFactory->make($script->getType())
                    ->setUrl($task->getUrl())
                    ->setScript($script)
                    ->execute();
            } catch (\Exception $e) {
                $this->bus->dispatch(new TaskFailed($executionHistory->getId(), $e));
                return;
            }

            if ($newOutput && !$previousOutput || $previousOutput->getOutput() !== $newOutput) {
                $output->setOutput($newOutput);
                $changes[] = new Change(
                    $previousOutput ? $previousOutput->getOutput() : null,
                    $newOutput,
                    $script->getType(),
                    $script->getLabel()
                );
                $this->entityManager->persist($output);

                $this->bus->dispatch(new SaveEvent(
                    new EventDescriptor(
                        $executionHistory->getId(),
                        PageContentChanged::ID,
                        new PageContentChangedEventDetails(
                            $script->getId(),
                            $newOutput,
                            $previousOutput ? $previousOutput->getOutput() : null
                        )
                    )
                ));
            }
        }

        $executionHistory->finish();
        $this->entityManager->persist($executionHistory);
        $this->entityManager->flush();

        if (count($changes)) {
            $this->bus->dispatch(new TaskChanged($executionHistory->getId(), $changes));
        }
    }
}