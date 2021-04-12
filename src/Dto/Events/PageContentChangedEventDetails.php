<?php

namespace App\Dto\Events;

class PageContentChangedEventDetails implements EventDetailsInterface
{
    private int $scriptId;

    private string $newOutput;

    private ?string $oldOutput;

    public function __construct(int $scriptId, string $newOutput, ?string $oldOutput)
    {
        $this->scriptId = $scriptId;
        $this->newOutput = $newOutput;
        $this->oldOutput = $oldOutput;
    }

    public function toString(): string
    {
        return json_encode([
            'script_id' => $this->scriptId,
            'new_output' => $this->newOutput,
            'old_output' => $this->oldOutput
        ]);
    }
}