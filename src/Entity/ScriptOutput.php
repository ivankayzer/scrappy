<?php

namespace App\Entity;

use App\Repository\ScriptOutputRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScriptOutputRepository::class)
 */
class ScriptOutput
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Script::class, inversedBy="scriptOutputs")
     */
    private $script;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $output;

    /**
     * @ORM\ManyToOne(targetEntity=TaskExecutionHistory::class, inversedBy="scriptOutputs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $execution_history;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScript(): ?Script
    {
        return $this->script;
    }

    public function setScript(?Script $script): self
    {
        $this->script = $script;

        return $this;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    public function setOutput(?string $output): self
    {
        $this->output = $output;

        return $this;
    }

    public function getExecutionHistory(): ?TaskExecutionHistory
    {
        return $this->execution_history;
    }

    public function setExecutionHistory(?TaskExecutionHistory $execution_history): self
    {
        $this->execution_history = $execution_history;

        return $this;
    }
}
