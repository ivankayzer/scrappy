<?php

namespace App\MessageHandler;

use App\Dto\EventDescriptor;
use App\Events\NotificationSentToTelegram;
use App\Message\EmmitEvent;
use App\Message\TaskChanged;
use App\Repository\TaskExecutionHistoryRepository;
use App\Repository\TaskRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TelegramBot\Api\BotApi;

class SendTelegramMessage implements MessageHandlerInterface
{
    private BotApi $botApi;

    private TaskExecutionHistoryRepository $taskExecutionRepository;

    private MessageBusInterface $bus;

    public function __construct(BotApi $botApi, TaskExecutionHistoryRepository $taskExecutionRepository, MessageBusInterface $bus)
    {
        $this->botApi = $botApi;
        $this->taskExecutionRepository = $taskExecutionRepository;
        $this->bus = $bus;
    }

    public function __invoke(TaskChanged $taskChanged)
    {
        $history = $this->taskExecutionRepository->find($taskChanged->getTaskHistoryId());

        $this->botApi->sendMessage(
            $history->getTask()->getUser()->getProviderId(),
            $history->getTask()->getName()
        );

        $this->bus->dispatch(new EmmitEvent(
            new EventDescriptor(
                $history->getId(),
                NotificationSentToTelegram::ID
            )
        ));
    }
}