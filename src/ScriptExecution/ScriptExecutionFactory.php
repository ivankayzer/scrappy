<?php

namespace App\ScriptExecution;

use Psr\Container\ContainerInterface;

class ScriptExecutionFactory
{
    public array $dictionary = [
        Execute::TYPE => Execute::class,
        Snapshot::TYPE => Snapshot::class,
    ];

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function make(string $type): ScriptExecutor
    {
        return $this->container->get($this->dictionary[$type]);
    }
}