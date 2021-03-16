<?php

namespace App\MessageHandler;

use App\Entity\ScriptOutput;
use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
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

        $taskChanged = false;

        foreach ($scripts as $script) {
            /** @var ScriptOutput|null $previousOutput */
            $previousOutput = $this->entityManager
                ->getRepository(ScriptOutput::class)
                ->findPrevious($script);

            $output = new ScriptOutput();
            $output->setExecutionHistory($executionHistory);
            $output->setScript($script);

            $newOutput = $this->scriptExecutionFactory->make($script->getType())
                ->setUrl($task->getUrl())
                ->setScript($script)
                ->execute();

            if (!$previousOutput || $previousOutput->getOutput() !== $newOutput) {
                $output->setOutput($newOutput);
                $taskChanged = true;
            }

            $this->entityManager->persist($output);
        }

        $executionHistory->finish();
        $this->entityManager->persist($executionHistory);
        $this->entityManager->flush();

        if ($taskChanged) {
            $this->bus->dispatch(new TaskChanged($task->getId()));
        }
    }
}