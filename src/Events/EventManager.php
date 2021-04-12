<?php

namespace App\Events;

use App\Entity\Event;
use Psr\Container\ContainerInterface;

class EventManager
{
    public array $dictionary = [
        ErrorDuringCheck::ID => ErrorDuringCheck::class,
        NotificationSentToTelegram::ID => NotificationSentToTelegram::class,
        PageContentChanged::ID => PageContentChanged::class,
    ];

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createFromEntity(Event $entity): EventInterface
    {
        $eventClass = $this->dictionary[$entity->getType()];

        $event = $this->container->get($eventClass);

        $event->setEvent($entity);

        return $event;
    }
}