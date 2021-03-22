<?php

namespace App\Events;

use App\Entity\Event;

abstract class AbstractEvent implements EventInterface
{
    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    abstract public function getColor(): string;

    abstract public function getIsImportant(): bool;

    abstract public function getName(): string;

    abstract public function getDetails(): ?string;

    abstract public function getChanges(): ?array;
}