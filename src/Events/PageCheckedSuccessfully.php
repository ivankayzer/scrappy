<?php

namespace App\Events;

class PageCheckedSuccessfully extends AbstractEvent
{
    const ID = 'page-checked-successfully';

    public function getColor(): string
    {
        return "blue";
    }

    public function getIsImportant(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return "Page checked successfully";
    }

    public function getDetails(): ?string
    {
        return null;
    }

    public function getChanges(): ?array
    {
        return null;
    }
}