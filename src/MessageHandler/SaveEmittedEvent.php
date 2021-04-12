<?php

namespace App\MessageHandler;

use App\Entity\Event;
use App\Entity\TaskExecutionHistory;
use App\Message\SaveEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveEmittedEvent implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(SaveEvent $emmitEvent)
    {
        /** @var TaskExecutionHistory $taskHistory */
        $taskHistory = $this->entityManager->getRepository(TaskExecutionHistory::class)
                ->find($emmitEvent->getEventDescriptor()->getTaskHistoryId());

        $event = new Event();
        $event->setType($emmitEvent->getEventDescriptor()->getEventId());
        $event->setTaskExecutionHistory($taskHistory);
        $event->setDetails($emmitEvent->getEventDescriptor()->getEventDetails());

        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }
}