<?php

namespace App\Events;

use App\Entity\Event;

interface EventInterface
{
    public function setEvent(Event $event): void;

    public function getColor(): string;

    public function getIsImportant(): bool;

    public function getName(): string;

    public function getDetails(): ?string;

    public function getChanges(): ?array;
}