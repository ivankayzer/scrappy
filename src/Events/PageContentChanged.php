<?php

namespace App\Events;

use App\Entity\Event;
use App\Repository\ScriptRepository;
use App\Repository\TaskRepository;
use App\ScriptExecution\Snapshot;

class PageContentChanged extends AbstractEvent
{
    const ID = 'page-content-changed';

    private ScriptRepository $scriptRepository;

    public function __construct(ScriptRepository $scriptRepository)
    {
        $this->scriptRepository = $scriptRepository;
    }

    public function getColor(): string
    {
        return "green";
    }

    public function getIsImportant(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return "Page content changed";
    }

    public function getDetails(): ?string
    {
        return null;
    }

    public function getChanges(): ?array
    {
        $defaultChanges = [
            'old' => null,
            'new' => null,
        ];

        if (!$this->event->getDetails()) {
            return $defaultChanges;
        }

        try {
            $changes = json_decode($this->event->getDetails(), true);
        } catch (\Exception $e) {
            return $defaultChanges;
        }

        if (!isset($changes['script_id'])) {
            return $defaultChanges;
        }

        $script = $this->scriptRepository->find($changes['script_id']);

        if ($script->getType() === Snapshot::TYPE) {
            return [
                'full' => 'Snapshot has changed'
            ];
        }

        $scriptLabel = $script->getLabel() ? $script->getLabel() . ': ' : '';

        return [
            'old' => $scriptLabel . $this->formatOutput($changes['old_output']),
            'new' => $scriptLabel . $this->formatOutput($changes['new_output']),
        ];
    }

    private function formatOutput(string $output): string
    {
        $strLimit = 100;

        $output = strip_tags($output);
        $output = str_replace(["\t", "\n"], [''], $output);
        $output = preg_replace('!\s+!', ' ', $output);

        if (strlen($output) <= $strLimit) {
            return $output;
        }

        return substr($output, 0, $strLimit);
    }
}