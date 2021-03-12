<?php

namespace App\MessageHandler;

use App\Message\TelegramMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TelegramBot\Api\BotApi;

class SendTelegramMessage implements MessageHandlerInterface
{
    private BotApi $botApi;

    public function __construct(BotApi $botApi)
    {
        $this->botApi = $botApi;
    }

    public function __invoke(TelegramMessage $telegramMessage)
    {
        $this->botApi->sendMessage(
            $telegramMessage->getTelegramId(),
            $telegramMessage->getMessage()
        );
    }
}