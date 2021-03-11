<?php

namespace App\Entity;

use App\Enums\TaskStatus;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notification_channel;

    /**
     * @ORM\Column(type="integer")
     */
    private $check_frequency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hours_of_activity;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Script::class, mappedBy="task")
     */
    private $scripts;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_checked;

    /**
     * @ORM\OneToMany(targetEntity=TaskExecutionHistory::class, mappedBy="task")
     */
    private $taskExecutionHistories;

    public function __construct()
    {
        $this->scripts = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->taskExecutionHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getStatus(): TaskStatus
    {
        return new TaskStatus($this->status);
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNotificationChannel(): ?string
    {
        return $this->notification_channel;
    }

    public function setNotificationChannel(?string $notification_channel): self
    {
        $this->notification_channel = $notification_channel;

        return $this;
    }

    public function getCheckFrequency(): ?int
    {
        return $this->check_frequency;
    }

    public function setCheckFrequency(int $check_frequency): self
    {
        $this->check_frequency = $check_frequency;

        return $this;
    }

    public function getHoursOfActivity(): ?string
    {
        return $this->hours_of_activity;
    }

    public function setHoursOfActivity(?string $hours_of_activity): self
    {
        $this->hours_of_activity = $hours_of_activity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Script[]
     */
    public function getScripts(): Collection
    {
        return $this->scripts;
    }

    public function addScript(Script $script): self
    {
        if (!$this->scripts->contains($script)) {
            $this->scripts[] = $script;
            $script->setTask($this);
        }

        return $this;
    }

    public function removeScript(Script $script): self
    {
        if ($this->scripts->removeElement($script)) {
            // set the owning side to null (unless already changed)
            if ($script->getTask() === $this) {
                $script->setTask(null);
            }
        }

        return $this;
    }

    public function getLastChecked(): ?\DateTimeInterface
    {
        return $this->last_checked;
    }

    public function setLastChecked(?\DateTimeInterface $last_checked): self
    {
        $this->last_checked = $last_checked;

        return $this;
    }

    /**
     * @return Collection|TaskExecutionHistory[]
     */
    public function getTaskExecutionHistories(): Collection
    {
        return $this->taskExecutionHistories;
    }

    public function addTaskExecutionHistory(TaskExecutionHistory $taskExecutionHistory): self
    {
        if (!$this->taskExecutionHistories->contains($taskExecutionHistory)) {
            $this->taskExecutionHistories[] = $taskExecutionHistory;
            $taskExecutionHistory->setTask($this);
        }

        return $this;
    }

    public function removeTaskExecutionHistory(TaskExecutionHistory $taskExecutionHistory): self
    {
        if ($this->taskExecutionHistories->removeElement($taskExecutionHistory)) {
            // set the owning side to null (unless already changed)
            if ($taskExecutionHistory->getTask() === $this) {
                $taskExecutionHistory->setTask(null);
            }
        }

        return $this;
    }
}
