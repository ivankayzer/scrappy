<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 *  @method static self active()
 *  @method static self inactive()
 *  @method static self warning()
 */
class TaskStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'active' => 1,
            'inactive' => -1,
            'warning' => 2,
        ];
    }
}