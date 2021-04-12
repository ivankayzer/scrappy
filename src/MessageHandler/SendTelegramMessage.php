<?php

namespace App\MessageHandler;

use App\Dto\Change;
use App\Dto\Events\EventDescriptor;
use App\Events\NotificationSentToTelegram;
use App\Message\SaveEvent;
use App\Message\TaskChanged;
use App\Repository\TaskExecutionHistoryRepository;
use App\ScriptExecution\Snapshot;
use App\Services\BotMessageComposer;
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

        $composer = new BotMessageComposer();

        $changes = array_map(function (Change $change) use ($composer) {
            $label = $change->getLabel() ? $change->getLabel() . ": " : "";

            if ($change->getType() === Snapshot::TYPE) {
                return "Snapshot of the page changed";
            }

            return sprintf(
                $composer->getChangeTemplate(),
                $label,
                $change->getOld(),
                $change->getNew()
            );
        }, $taskChanged->getChanges());

        $message = $composer->bold($task->getName())
            ->implode($changes)
            ->link($task->getUrl())
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