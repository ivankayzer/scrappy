<?php

namespace App\Events;

use App\Entity\Event;
use App\Repository\TaskRepository;

class PageContentChanged extends AbstractEvent
{
    const ID = 'page-content-changed';

    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getColor(): string
    {
        return "green";
    }

    public function getIsImportant(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return "Page content changed";
    }

    public function getDetails(): ?string
    {
        return null;
    }

    public function getChanges(): ?array
    {
        $task = $this->event->getTaskExecutionHistory()->getTask();

        return [
            [
                'old' => 'Price: 2499,00 PLN',
                'new' => 'Price: 2799,00 PLN',
            ]
        ];
    }
}