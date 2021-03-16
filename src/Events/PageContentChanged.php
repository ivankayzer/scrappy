<?php

namespace App\Events;

class PageContentChanged extends AbstractEvent
{
    const ID = 'page-content-changed';

    public function getColor(): string
    {
        return "green";
    }

    public function getIsImportant(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return "Page content changed";
    }

    public function getDetails(): ?string
    {
        return null;
    }

    public function getChanges(): ?array
    {
        return [
            [
                'old' => 'Price: 2499,00 PLN',
                'new' => 'Price: 2799,00 PLN',
            ]
        ];
    }
}