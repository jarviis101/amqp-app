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
    private bool $status;

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

    public function __construct(User $user, string $title, string $description, bool $status = false)
    {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = new DateTimeImmutable();
        $this->tasks = new ArrayCollection();
        $this->priority = new Priority();
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
            throw new PriorityAlreadyExist('Role is already same.');
        }
        $this->priority = $priority;
    }

    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
        ];
    }
}
