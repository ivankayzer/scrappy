<?php

namespace App\MessageHandler;

use App\Entity\ScriptOutput;
use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
use App\Message\TaskExecutionMessage;
use App\Message\TelegramMessage;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ExecuteTask implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    private MessageBusInterface $bus;

    private Client $guzzle;

    public function __construct(EntityManagerInterface $entityManager, MessageBusInterface $bus, Client $client)
    {
        $this->entityManager = $entityManager;
        $this->bus = $bus;
        $this->guzzle = $client;
    }

    public function __invoke(TaskExecutionMessage $taskExecutionMessage)
    {
        /** @var Task $task */
        $task = $this->entityManager->getRepository(Task::class)
            ->find($taskExecutionMessage->getTaskId());

        $scripts = $task->getScripts();

        $executionHistory = new TaskExecutionHistory();
        $executionHistory->setTask($task);

        foreach ($scripts as $script) {
            /** @var ScriptOutput|null $previousOutput */
            $previousOutput = $this->entityManager
                ->getRepository(ScriptOutput::class)
                ->findPrevious($script);

            $output = new ScriptOutput();
            $output->setExecutionHistory($executionHistory);
            $output->setScript($script);

            if ($script->getType() === 'snapshot') {
                $response = $this->guzzle->get($task->getUrl());
                $newOutput = $response->getBody()->getContents();
            } elseif ($script->getType() === 'execute') {
                $puppeteer = new Puppeteer;

                $browser = $puppeteer->launch([
                    'args' => [
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                    ],
                ]);
                $page = $browser->newPage();
                $page->setViewport(['width' => 1366, 'height' => 768]);
                $page->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 11_0_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.96 Safari/537.36');

                $page->addScriptTag(['url' => 'https://code.jquery.com/jquery-3.5.1.min.js']);

                $page->goto($task->getUrl());
                $newOutput = $page->evaluate(JsFunction::createWithBody("
                            return document.innerHtml;
                        "));
                $browser->close();
            }

            if (!$previousOutput || $previousOutput->getOutput() !== $newOutput) {
                $output->setOutput($newOutput);

                $this->bus->dispatch(
                    new TelegramMessage(
                        $task->getUser()->getProviderId(),
                        'Changed: ' . $task->getName()
                    )
                );
            }

            $this->entityManager->persist($output);
        }

        $executionHistory->finish();

        $this->entityManager->persist($executionHistory);

        $this->entityManager->flush();
    }
}