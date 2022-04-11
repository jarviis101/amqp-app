<?php

namespace App\DTO\Task;

use App\Entity\Priority;
use App\Entity\Task;
use App\Entity\User;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

final class EditTaskDTO
{
    /**
     * @JMS\Type("string")
     */
    public ?string $title;

    /**
     * @JMS\Type("string")
     */
    public ?string $description;

    /**
     * @JMS\Type("int")
     */
    public ?Priority $priority = null;

    /**
     * @JMS\Type("bool")
     */
    public ?bool $status;
}
