<?php

namespace App\Entity;

use App\Entity\Traits\ModifyEntityTrait;
use App\Exception\PriorityAlreadyExist;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Task
{
    use ModifyEntityTrait;

    public const TODO = false;
    public const DONE = true;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private string $title;

    /**
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private string $description;

    /**
     * @ORM\Column(type="boolean", options={"default": false, "comment":"0 - todo, 1 - done"})
     */
    private bool $status = self::TODO;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Task")
     * @ORM\JoinTable(
     *     name="subtasks",
     *     joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="sub_task_id", referencedColumnName="id")}
     * )
     */
    private Collection $tasks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="task_priority", nullable=false, options={"default": 0})
     */
    private Priority $priority;

    public function __construct(User $user, Priority $priority, string $title, string $description)
    {
        $this->user = $user;
        $this->priority = $priority;
        $this->title = $title;
        $this->description = $description;
        $this->createdAt = new DateTimeImmutable();
        $this->tasks = new ArrayCollection();
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addTask(Task $task) {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Priority $priority
     * @throws PriorityAlreadyExist
     */
    public function setPriority(Priority $priority): void
    {
        if ($this->priority->equals($priority)) {
            throw new PriorityAlreadyExist('Priority is already same.');
        }
        $this->priority = $priority;
    }

    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'status' => $this->isStatus(),
            'priority' => $this->getPriority()->getLevel(),
        ];
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
