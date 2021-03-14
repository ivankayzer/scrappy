<?php

namespace App\ScriptExecution;

use App\Entity\Script;

interface ScriptExecutor
{
    public function execute(): string;

    public function setUrl(string $url): self;

    public function setScript(Script $script): self;
}