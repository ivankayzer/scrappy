<?php

namespace App\Command;

use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use React\EventLoop\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCron extends Command
{
    protected static $defaultName = 'cron:run';

    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @var Client
     */
    private Client $guzzle;

    public function __construct(string $name = null, EntityManagerInterface $entityManager, Client $guzzle)
    {
        parent::__construct($name);

        $this->taskRepository = $taskRepository;
        $this->guzzle = $guzzle;
    }

    protected function configure()
    {
        $this->setDescription('Run ReactPHP event loop');

        $this->addArgument(
            'interval',
            InputArgument::OPTIONAL,
            'Interval to run event loop',
            1
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = Factory::create();

        $loop->addPeriodicTimer($input->getArgument('interval'), function () {
            $tasks = $this->taskRepository->findNeverRun();

            foreach ($tasks as $task) {
                /** @var Task $task */
                $scripts = $task->getScripts();

                $executionHistory = new TaskExecutionHistory();

                foreach ($scripts as $script) {
                    if ($script->getType() === 'snapshot') {
                        $response = $this->guzzle->get($task->getUrl());

                        dd($response->getBody()->getContents());
                    }
                }
            }
        });

        $loop->run();
    }
}