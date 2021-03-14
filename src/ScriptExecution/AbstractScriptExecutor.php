<?php

namespace App\ScriptExecution;

use App\Entity\Script;

abstract class AbstractScriptExecutor implements ScriptExecutor
{
    protected string $url;

    protected Script $script;

    abstract public function execute(): string;

    public function setUrl(string $url): ScriptExecutor
    {
        $this->url = $url;

        return $this;
    }

    public function setScript(Script $script): ScriptExecutor
    {
        $this->script = $script;

        return $this;
    }
}