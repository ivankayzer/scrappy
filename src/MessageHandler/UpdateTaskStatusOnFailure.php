<?php

namespace App\MessageHandler;

use App\Dto\Events\EventDescriptor;
use App\Dto\Events\PlainTextEventDetails;
use App\Enums\TaskStatus;
use App\Events\ErrorDuringCheck;
use App\Message\SaveEvent;
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

        $eventDescriptor = new EventDescriptor(
            $history->getId(),
            ErrorDuringCheck::ID,
            new PlainTextEventDetails($taskFailed->getException()->getMessage())
        );

        $this->bus->dispatch(new SaveEvent($eventDescriptor));

        $task->setStatus(TaskStatus::warning()->value);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}