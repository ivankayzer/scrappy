<?php

namespace App\Message;

class TelegramMessage
{
    private string $telegramId;

    private string $message;

    public function __construct(string $telegramId, string $message)
    {
        $this->telegramId = $telegramId;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getTelegramId(): string
    {
        return $this->telegramId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}