<?php

namespace App\MessageHandler;

use App\Dto\EventDescriptor;
use App\Enums\TaskStatus;
use App\Events\ErrorDuringCheck;
use App\Message\EmmitEvent;
use App\Message\TaskFailed;
use App\Repository\TaskExecutionHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateTaskStatusOnFailure implements MessageHandlerInterface
{
    private TaskExecutionHistoryRepository $taskExecutionRepository;

    private EntityManagerInterface $entityManager;

    private MessageBusInterface $bus;

    public function __construct(TaskExecutionHistoryRepository $taskExecutionRepository, EntityManagerInterface $entityManager, MessageBusInterface $bus)
    {
        $this->taskExecutionRepository = $taskExecutionRepository;
        $this->entityManager = $entityManager;
        $this->bus = $bus;
    }

    public function __invoke(TaskFailed $taskFailed): void
    {
        $history = $this->taskExecutionRepository->find($taskFailed->getTaskHistoryId());

        $task = $history->getTask();

        $this->bus->dispatch(new EmmitEvent(
            new EventDescriptor(
                $history->getId(),
                ErrorDuringCheck::ID,
                $taskFailed->getException()->getMessage()
            )
        ));

        $task->setStatus(TaskStatus::warning()->value);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}