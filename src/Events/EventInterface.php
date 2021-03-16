<?php

namespace App\Events;

interface EventInterface
{
    public function getColor(): string;

    public function getIsImportant(): bool;

    public function getName(): string;

    public function getDetails(): ?string;

    public function getChanges(): ?array;
}