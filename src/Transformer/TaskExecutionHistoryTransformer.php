<?php

namespace App\Transformer;

use App\Entity\TaskExecutionHistory;
use Carbon\Carbon;

class TaskExecutionHistoryTransformer
{
    private TransformerManager $transformerManager;

    public function __construct(TransformerManager $transformerManager)
    {
        $this->transformerManager = $transformerManager;
    }

    public function transform(TaskExecutionHistory $history): array
    {
        $events = $this->transformerManager->transformMany(
            $history->getEvents()->toArray()
        );

        return [
            'id' => $history->getId(),
            'duration' => $this->calculateDuration(
                $history->getStartedAt(),
                $history->getExecutedAt()
            ),
            'events' => $events,
        ];
    }

    private function calculateDuration(?\DateTimeInterface $startedAt, ?\DateTimeInterface $executedAt): string
    {
        if (!$executedAt) {
            return "not finished";
        }

        $diff = Carbon::instance($executedAt)->diffInSeconds($startedAt);

        return sprintf('%s seconds', $diff);
    }

    private function formatDate(?\DateTimeInterface $date): string
    {
        if (!$date) {
            return "";
        }

        return Carbon::instance($date)->diffForHumans();
    }
}