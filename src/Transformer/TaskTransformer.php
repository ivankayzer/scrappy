<?php

namespace App\Transformer;

use App\Entity\Task;
use App\Enums\TaskStatus;
use Carbon\Carbon;

class TaskTransformer
{
    private TransformerManager $transformerManager;

    public function __construct(TransformerManager $transformerManager)
    {
        $this->transformerManager = $transformerManager;
    }

    public function transform(Task $task): array
    {
        $events = $this->transformerManager->transformMany(
            $task->getTaskExecutionHistories()->toArray()
        );

        return [
            'id' => $task->getId(),
            'name' => $task->getName(),
            'url' => $task->getUrl(),
            'isActive' => $task->getStatus()->equals(TaskStatus::active()),
            'lastChecked' => $this->formatDate($task->getLastChecked()),
            'checkFrequency' => $this->formatFrequency($task->getCheckFrequency()),
            'notificationChannel' => $task->getNotificationChannel(),
            'needsAttention' => $task->getStatus()->equals(TaskStatus::warning()),
            'events' => $events,
        ];
    }

    private function formatDate(?\DateTimeInterface $date): string
    {
        if (!$date) {
            return "";
        }

        return Carbon::instance($date)->diffForHumans();
    }

    private function formatFrequency(?int $frequency): string
    {
        if (!$frequency) {
            return "";
        }

        return sprintf('every %s seconds', $frequency);
    }
}