<?php

namespace App\Dto\Events;

class PlainTextEventDetails implements EventDetailsInterface
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function toString(): string
    {
        return $this->text;
    }
}