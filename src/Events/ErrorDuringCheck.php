<?php

namespace App\Events;

class ErrorDuringCheck extends AbstractEvent
{
    const ID = 'error-during-check';

    public function getColor(): string
    {
        return "red";
    }

    public function getIsImportant(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return "An error occurred during page check";
    }

    public function getDetails(): ?string
    {
        return $this->event->getDetails();
    }

    public function getChanges(): ?array
    {
        return null;
    }
}