<?php

namespace App\Command;

use App\Entity\ScriptOutput;
use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use React\EventLoop\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TelegramBot\Api\BotApi;

class RunCron extends Command
{
    protected static $defaultName = 'cron:run';

    private EntityManagerInterface $entityManager;

    private Client $guzzle;

    private BotApi $bot;

    public function __construct(string $name = null, EntityManagerInterface $entityManager, string $telegramToken)
    {
        parent::__construct($name);

        $this->entityManager = $entityManager;

        $this->guzzle = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 11_2_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36',
            ]
        ]);

        $this->bot = new BotApi($telegramToken);
    }

    protected function configure()
    {
        $this->setDescription('Run ReactPHP event loop');

        $this->addArgument(
            'interval',
            InputArgument::OPTIONAL,
            'Interval to run event loop',
            5
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = Factory::create();

        $loop->addPeriodicTimer($input->getArgument('interval'), function () {
            echo "SCANNING" . PHP_EOL;

            $taskRepository = $this->entityManager->getRepository(Task::class);

            $tasks = array_merge(
                $taskRepository->findNeverRun(),
                $taskRepository->findWaitingForCheck(),
            );

            foreach ($tasks as $task) {
                /** @var Task $task */
                echo "EXECUTING TASK: " . $task->getName() . PHP_EOL;
                $scripts = $task->getScripts();

                $executionHistory = new TaskExecutionHistory();
                $executionHistory->setTask($task);

                foreach ($scripts as $script) {
                    echo "EXECUTING SCRIPT: " . $script->getId() . PHP_EOL;
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
                        echo "FOUND CHANGES. NOTIFYING" . PHP_EOL;
                        $output->setOutput($newOutput);
                        $this->bot->sendMessage($task->getUser()->getProviderId(), 'Changed: ' . $task->getName());
                    }

                    $this->entityManager->persist($output);
                }

                $executionHistory->finish();
                $task->finish();

                $this->entityManager->persist($executionHistory);
                $this->entityManager->persist($task);
            }

            $this->entityManager->flush();
        });

        $loop->run();
    }
}