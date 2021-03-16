<?php

namespace App\Transformer;

use App\Entity\Event;
use App\Events\EventManager;
use Carbon\Carbon;

class EventTransformer
{
    private EventManager $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function transform(Event $entity): array
    {
        $event = $this->eventManager->createFromEntity($entity);

        return [
            'id' => $entity->getId(),
            'name' => $event->getName(),
            'subtext' => $event->getDetails(),
            'isImportant' => $event->getIsImportant(),
            'timestamp' => $this->formatDate(
                $entity->getCreatedAt()
            ),
            'color' => $event->getColor(),
            'changes' => $event->getChanges(),
        ];
    }

    private function formatDate(?\DateTimeInterface $date): string
    {
        if (!$date) {
            return "";
        }

        return Carbon::instance($date)->diffForHumans();
    }
}