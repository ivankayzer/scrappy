<?php

namespace App\MessageHandler;

use App\Dto\Change;
use App\Dto\EventDescriptor;
use App\Events\NotificationSentToTelegram;
use App\Message\EmmitEvent;
use App\Message\TaskChanged;
use App\Repository\TaskExecutionHistoryRepository;
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

        $task = $history->getTask();

        $changes = array_map(function (Change $change) {
            $label = $change->getLabel() ? $change->getLabel() . ": " : "";
            return sprintf('%s ~%s~ → %s', $label, $change->getOld(), $change->getNew());
        }, $taskChanged->getChanges());

        $message = [
            sprintf("*%s*\n", $task->getName()),
            implode("\n", $changes),
            sprintf("[Open URL](%s)", $task->getUrl()),
        ];

        $this->botApi->sendMessage(
            $task->getUser()->getProviderId(),
            implode("\n", $message),
            'MarkdownV2',
        );

        $this->bus->dispatch(new EmmitEvent(
            new EventDescriptor(
                $history->getId(),
                NotificationSentToTelegram::ID
            )
        ));
    }
}