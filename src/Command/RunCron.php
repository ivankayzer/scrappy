<?php

namespace App\Command;

use App\Entity\Task;
use App\Message\TaskExecutionMessage;
use Doctrine\ORM\EntityManagerInterface;
use React\EventLoop\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RunCron extends Command
{
    protected static $defaultName = 'cron:run';

    private EntityManagerInterface $entityManager;

    private MessageBusInterface $messageBus;

    public function __construct(string $name = null, EntityManagerInterface $entityManager, MessageBusInterface $messageBus)
    {
        parent::__construct($name);

        $this->entityManager = $entityManager;

        $this->messageBus = $messageBus;
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
            $taskRepository = $this->entityManager->getRepository(Task::class);

            $tasks = array_merge(
                $taskRepository->findNeverRun(),
                $taskRepository->findWaitingForCheck(),
            );

            foreach ($tasks as $task) {
                $this->messageBus->dispatch(new TaskExecutionMessage($task->getId()));
            }
        });

        $loop->run();
    }
}