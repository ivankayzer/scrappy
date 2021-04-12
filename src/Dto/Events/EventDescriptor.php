<?php

namespace App\Dto\Events;

class EventDescriptor
{
    private int $taskHistoryId;

    private string $eventId;

    private ?EventDetailsInterface $eventDetails;

    public function __construct(int $taskHistoryId, string $eventId, EventDetailsInterface $eventDetails = null)
    {
        $this->taskHistoryId = $taskHistoryId;
        $this->eventId = $eventId;
        $this->eventDetails = $eventDetails;
    }

    public function getTaskHistoryId(): int
    {
        return $this->taskHistoryId;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getEventDetails(): ?string
    {
        return $this->eventDetails ? $this->eventDetails->toString() : null;
    }
}