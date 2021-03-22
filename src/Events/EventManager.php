<?php

namespace App\Events;

use App\Entity\Event;

class EventManager
{
    public $dictionary = [
        ErrorDuringCheck::ID => ErrorDuringCheck::class,
        NotificationSentToTelegram::ID => NotificationSentToTelegram::class,
        PageCheckedSuccessfully::ID => PageCheckedSuccessfully::class,
        PageContentChanged::ID => PageContentChanged::class,
    ];

    public function createFromEntity(Event $entity): EventInterface
    {
        $eventClass = $this->dictionary[$entity->getType()];

        return new $eventClass($entity);
    }
}