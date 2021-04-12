<?php

namespace App\Message;

use App\Dto\EventDescriptor;

class SaveEvent
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