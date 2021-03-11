<?php

namespace App\Entity;

use App\Repository\TaskExecutionHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskExecutionHistoryRepository::class)
 */
class TaskExecutionHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="taskExecutionHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    /**
     * @ORM\Column(type="datetime")
     */
    private $executed_at;

    /**
     * @ORM\OneToMany(targetEntity=ScriptOutput::class, mappedBy="execution_history")
     */
    private $scriptOutputs;

    public function __construct()
    {
        $this->scriptOutputs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getExecutedAt(): ?\DateTimeInterface
    {
        return $this->executed_at;
    }

    public function setExecutedAt(\DateTimeInterface $executed_at): self
    {
        $this->executed_at = $executed_at;

        return $this;
    }

    /**
     * @return Collection|ScriptOutput[]
     */
    public function getScriptOutputs(): Collection
    {
        return $this->scriptOutputs;
    }

    public function addScriptOutput(ScriptOutput $scriptOutput): self
    {
        if (!$this->scriptOutputs->contains($scriptOutput)) {
            $this->scriptOutputs[] = $scriptOutput;
            $scriptOutput->setExecutionHistory($this);
        }

        return $this;
    }

    public function removeScriptOutput(ScriptOutput $scriptOutput): self
    {
        if ($this->scriptOutputs->removeElement($scriptOutput)) {
            // set the owning side to null (unless already changed)
            if ($scriptOutput->getExecutionHistory() === $this) {
                $scriptOutput->setExecutionHistory(null);
            }
        }

        return $this;
    }
}
