<?php

namespace App\Message;

class TaskChanged
{
    private int $taskHistoryId;

    private array $changes;

    public function __construct(int $taskHistoryId, array $changes)
    {
        $this->taskHistoryId = $taskHistoryId;
        $this->changes = $changes;
    }

    public function getTaskHistoryId(): int
    {
        return $this->taskHistoryId;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }
}