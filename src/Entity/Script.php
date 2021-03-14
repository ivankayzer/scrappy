<?php

namespace App\Entity;

use App\Repository\ScriptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScriptRepository::class)
 */
class Script
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="scripts")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $task;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $execution_order;

    /**
     * @ORM\OneToMany(targetEntity=ScriptOutput::class, mappedBy="script")
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getExecutionOrder(): ?int
    {
        return $this->execution_order;
    }

    public function setExecutionOrder(int $execution_order): self
    {
        $this->execution_order = $execution_order;

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
            $scriptOutput->setScript($this);
        }

        return $this;
    }

    public function removeScriptOutput(ScriptOutput $scriptOutput): self
    {
        if ($this->scriptOutputs->removeElement($scriptOutput)) {
            // set the owning side to null (unless already changed)
            if ($scriptOutput->getScript() === $this) {
                $scriptOutput->setScript(null);
            }
        }

        return $this;
    }
}
