<?php

namespace App\Message;

class TaskChanged
{
    private int $taskHistoryId;

    public function __construct(int $taskHistoryId)
    {
        $this->taskHistoryId = $taskHistoryId;
    }

    public function getTaskHistoryId(): int
    {
        return $this->taskHistoryId;
    }
}