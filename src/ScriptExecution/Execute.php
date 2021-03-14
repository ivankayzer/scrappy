<?php

namespace App\ScriptExecution;

use App\Services\Browser;
use Nesk\Rialto\Data\JsFunction;

class Execute extends AbstractScriptExecutor
{
    const TYPE = 'execute';

    public function execute(): string
    {
        $browser = new Browser();

        $page = $browser->createPage();

        $page->goto($this->url);

        $newOutput = $page->evaluate(JsFunction::createWithBody("return {$this->script->getCode()};"));

        $browser->close();

        return $newOutput;
    }
}