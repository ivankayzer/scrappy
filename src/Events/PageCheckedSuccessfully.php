<?php

namespace App\Events;

class PageCheckedSuccessfully
{
//    public static function createFromEntity()

    public function getColor(): string
    {
        return "blue";
    }

    public function getIsImportant(): bool
    {
        return false;
    }
}