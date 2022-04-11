<?php

namespace App\DTO\Task;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

class TaskDTO
{
    /**
     * @JMS\Type("integer")
     */
    public int $id;

    /**
     * @JMS\Type("string")
     */
    public string $title;

    /**
     * @JMS\Type("string")
     */
    public string $description;

    /**
     * @JMS\Type("string")
     */
    public string $status;

    /**
     * @JMS\Type("integer")
     */
    public int $priority;

    /**
     * @JMS\Type("string")
     */
    public DateTimeImmutable $createdAt;

    /**
     * @var TaskDTO[]
     */
    public array $subtasks;

    public function __construct(int $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }
}
