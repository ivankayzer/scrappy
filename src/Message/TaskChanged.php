<?php

namespace App\Message;

class TaskChanged
{
    private int $taskId;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }
}