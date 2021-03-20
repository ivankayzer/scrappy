<?php

namespace App\Dto;

class Change
{
    private ?string $old;

    private string $new;

    private ?string $label;

    public function __construct(?string $old, string $new, ?string $label = null)
    {
        $this->old = $old;
        $this->new = $new;
        $this->label = $label;
    }

    public function getOld(): ?string
    {
        return $this->old;
    }

    public function getNew(): string
    {
        return $this->new;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }
}