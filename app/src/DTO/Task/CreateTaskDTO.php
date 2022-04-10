<?php

namespace App\DTO\Task;

use App\Entity\Priority;
use App\Entity\Task;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTaskDTO
{
    /**
     * @JMS\Type("string")
     * @Assert\NotBlank()
     */
    public string $title;

    /**
     * @JMS\Type("string")
     * @Assert\NotBlank()
     */
    public string $description;

    /**
     * @JMS\Type("int")
     */
    public Priority $priority;

    /**
     * @JMS\Type("int")
     * @JMS\SerializedName("parent_id")
     */
    public ?Task $parentTask = null;

}
