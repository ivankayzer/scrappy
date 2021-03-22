<?php

namespace App\Events;

class NotificationSentToTelegram extends AbstractEvent
{
    const ID = 'notification-sent-to-telegram';

    public function getColor(): string
    {
        return "blue";
    }

    public function getIsImportant(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return "Notification sent to Telegram";
    }

    public function getDetails(): ?string
    {
        return null;
    }

    public function getChanges(): ?array
    {
        return null;
    }
}