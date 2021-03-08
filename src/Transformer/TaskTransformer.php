<?php

namespace App\Transformer;

use App\Entity\Task;
use App\Enums\TaskStatus;

class TaskTransformer implements TransformerInterface
{
    /**
     * @var Task
     */
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function transform(): array
    {
        return [
            'id' => $this->task->getId(),
            'name' => $this->task->getName(),
            'url' => $this->task->getUrl(),
            'isActive' => $this->task->getStatus()->equals(TaskStatus::active()),
            'lastChecked' => $this->task->getLastChecked(),
            'checkFrequency' => $this->task->getCheckFrequency(),
            'notificationChannel' => $this->task->getNotificationChannel(),
            'needsAttention' => $this->task->getStatus()->equals(TaskStatus::warning()),
            'events' => [],
        ];
    }
}