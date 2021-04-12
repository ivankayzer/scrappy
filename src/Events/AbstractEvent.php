<?php

namespace App\Events;

use App\Entity\Event;

abstract class AbstractEvent implements EventInterface
{
    protected Event $event;

    abstract public function getColor(): string;

    abstract public function getIsImportant(): bool;

    abstract public function getName(): string;

    abstract public function getDetails(): ?string;

    abstract public function getChanges(): ?array;

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }
}