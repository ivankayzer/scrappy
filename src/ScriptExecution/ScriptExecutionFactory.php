<?php

namespace App\ScriptExecution;

class ScriptExecutionFactory
{
    public array $dictionary = [
        Execute::TYPE => Execute::class,
        Snapshot::TYPE => Snapshot::class,
    ];

    public function make(string $type): ScriptExecutor
    {
        return new $this->dictionary[$type];
    }
}