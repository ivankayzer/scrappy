<?php

namespace App\Message;

use App\Dto\EventDescriptor;

class EmmitEvent
{
    private EventDescriptor $eventDescriptor;

    public function __construct(EventDescriptor $eventDescriptor)
    {
        $this->eventDescriptor = $eventDescriptor;
    }

    public function getEventDescriptor(): EventDescriptor
    {
        return $this->eventDescriptor;
    }
}