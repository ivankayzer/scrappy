<?php

namespace App\MessageHandler;

use App\Message\TaskChanged;
use App\Repository\TaskRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TelegramBot\Api\BotApi;

class SendTelegramMessage implements MessageHandlerInterface
{
    private BotApi $botApi;

    private TaskRepository $taskRepository;

    public function __construct(BotApi $botApi, TaskRepository $taskRepository)
    {
        $this->botApi = $botApi;
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(TaskChanged $taskChanged)
    {
        $task = $this->taskRepository->find($taskChanged->getTaskId());

        $this->botApi->sendMessage(
            $task->getUser()->getProviderId(),
            $task->getName()
        );
    }
}