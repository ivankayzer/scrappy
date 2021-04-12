<?php

namespace App\MessageHandler;

use App\Dto\Events\EventDescriptor;
use App\Events\NotificationSentToTelegram;
use App\Message\SaveEvent;
use App\Message\TaskFailed;
use App\Repository\TaskExecutionHistoryRepository;
use App\Services\BotMessageComposer;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TelegramBot\Api\BotApi;

class NotifyAboutTaskFailure implements MessageHandlerInterface
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

    public function __invoke(TaskFailed $taskFailed): void
    {
        $history = $this->taskExecutionRepository->find($taskFailed->getTaskHistoryId());

        $task = $history->getTask();

        $composer = new BotMessageComposer();
        $message = $composer->bold($task->getName())
            ->line('Task execution failed')
            ->getMessage();

        $this->botApi->sendMessage(
            $task->getUser()->getProviderId(),
            $message,
            $composer->getParseMode()
        );

        $this->bus->dispatch(new SaveEvent(
            new EventDescriptor(
                $history->getId(),
                NotificationSentToTelegram::ID
            )
        ));
    }
}