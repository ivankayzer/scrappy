<?php

namespace App\Services;

class BotMessageComposer
{
    private array $message = [];

    private string $newLineSeparator = "\n";

    private string $parseMode = 'MarkdownV2';

    public function bold(string $text): self
    {
        $this->message[] = sprintf('*%s*', $this->formatOutput($text));

        return $this;
    }

    public function line(string $text): self
    {
        $this->message[] = $this->formatOutput($text);

        return $this;
    }

    public function emptyLine(): self
    {
        $this->message[] = $this->newLineSeparator;

        return $this;
    }

    public function implode(array $toImplode, ?string $separator = null): self
    {
        if (!$separator) {
            $separator = $this->newLineSeparator;
        }

        $imploded = implode($separator, $toImplode);

        $this->message[] = $this->formatOutput($imploded);

        return $this;
    }

    public function link(string $url, string $urlText = 'Open URL'): self
    {
        $this->message[] = sprintf('[%s](%s)', $this->formatOutput($urlText), $url);

        return $this;
    }

    public function getMessage(): string
    {
        return implode($this->newLineSeparator, $this->message);
    }

    public function getParseMode(): string
    {
        return $this->parseMode;
    }

    public function getChangeTemplate(): string
    {
        return '%s ~%s~ → %s';
    }

    private function formatOutput(string $output): string
    {
        if (!$output) {
            return "";
        }

        return str_replace(
            ['-'],
            ['\-'],
            strip_tags($output)
        );
    }
}