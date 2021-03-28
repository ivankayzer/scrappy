<?php

namespace App\Message;

use Exception;

class TaskFailed
{
    private int $taskHistoryId;

    private Exception $exception;

    public function __construct(int $taskHistoryId, Exception $exception)
    {
        $this->taskHistoryId = $taskHistoryId;
        $this->exception = $exception;
    }

    public function getTaskHistoryId(): int
    {
        return $this->taskHistoryId;
    }

    public function getException(): Exception
    {
        return $this->exception;
    }
}