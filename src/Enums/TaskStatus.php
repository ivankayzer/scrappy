<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 *  @method static self active()
 *  @method static self disabled()
 *  @method static self warning()
 */
class TaskStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'active' => 1,
            'disabled' => -1,
            'warning' => 2,
        ];
    }
}