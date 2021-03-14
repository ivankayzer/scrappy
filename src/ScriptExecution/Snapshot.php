<?php

namespace App\ScriptExecution;

use GuzzleHttp\Client;

class Snapshot extends AbstractScriptExecutor
{
    const TYPE = 'snapshot';

    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function execute()
    {
        $response = $this->guzzle->get($this->url);

        return $response->getBody()->getContents();
    }
}