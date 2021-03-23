<?php

namespace App\MessageHandler;

use App\Dto\Change;
use App\Dto\EventDescriptor;
use App\Entity\ScriptOutput;
use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
use App\Events\ErrorDuringCheck;
use App\Events\PageCheckedSuccessfully;
use App\Events\PageContentChanged;
use App\Message\EmmitEvent;
use App\Message\TaskChanged;
use App\Message\TaskExecutionMessage;
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

    public function __invoke(TaskExecutionMessage $taskExecutionMessage)
    {
        /** @var Task $task */
        $task = $this->entityManager->getRepository(Task::class)
            ->find($taskExecutionMessage->getTaskId());

        $scripts = $task->getScripts();

        $executionHistory = new TaskExecutionHistory();
        $executionHistory->setTask($task);

        $changes = [];

        foreach ($scripts as $script) {
            /** @var ScriptOutput|null $previousOutput */
            $previousOutput = $this->entityManager
                ->getRepository(ScriptOutput::class)
                ->findPrevious($script);

            $output = new ScriptOutput();
            $output->setExecutionHistory($executionHistory);
            $output->setScript($script);

            try {
                $newOutput = $this->scriptExecutionFactory->make($script->getType())
                    ->setUrl($task->getUrl())
                    ->setScript($script)
                    ->execute();
            } catch (\Exception $e) {
                $this->bus->dispatch(new EmmitEvent(
                    new EventDescriptor(
                        $executionHistory->getId(),
                        ErrorDuringCheck::ID,
                        $e->getMessage()
                    )
                ));
            }

            if (!$previousOutput || $previousOutput->getOutput() !== $newOutput) {
                $output->setOutput($newOutput);
                $changes[] = new Change(
                    $previousOutput ? $previousOutput->getOutput() : null,
                    $newOutput,
                    $script->getType(),
                    $script->getLabel()
                );
            }

            $this->entityManager->persist($output);
        }

        $executionHistory->finish();
        $this->entityManager->persist($executionHistory);
        $this->entityManager->flush();

        $this->bus->dispatch(new EmmitEvent(
            new EventDescriptor(
                $executionHistory->getId(),
                PageCheckedSuccessfully::ID
            )
        ));

        if (count($changes)) {
            $this->bus->dispatch(new TaskChanged($executionHistory->getId(), $changes));
            $this->bus->dispatch(new EmmitEvent(
                new EventDescriptor(
                    $executionHistory->getId(),
                    PageContentChanged::ID
                )
            ));
        }
    }
}