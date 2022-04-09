<?php

namespace App\Entity;

use App\Entity\Traits\ModifyEntityTrait;
use DateTimeImmutable;
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

//    private User $user;
//    private $priority;
    public function __construct(string $title, string $description, bool $status = false)
    {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = new DateTimeImmutable();
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
