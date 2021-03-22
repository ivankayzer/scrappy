<?php

namespace App\Services;

use Nesk\Puphpeteer\Puppeteer;
use Nesk\Puphpeteer\Resources\Browser as NeskBrowser;
use Nesk\Puphpeteer\Resources\Page;

class Browser
{
    private NeskBrowser $browser;

    public function __construct()
    {
        $puppeteer = new Puppeteer;

        $this->browser = $puppeteer->launch([
            'args' => [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
            ],
        ]);
    }

    public function createPage(): Page
    {
        $page = $this->browser->newPage();

        $page->setViewport(['width' => 1366, 'height' => 768]);
        $page->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 11_0_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.96 Safari/537.36');

        $page->addScriptTag(['url' => 'https://code.jquery.com/jquery-3.5.1.min.js']);

        return $page;
    }

    public function close(): void
    {
        $this->browser->close();
    }
}