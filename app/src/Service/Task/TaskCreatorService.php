<?php

namespace App\Service\Task;

use App\DTO\Task\CreateTaskDTO;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskCreatorService
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(CreateTaskDTO $dto): Task {
        $task = new Task($dto->user, $dto->title, $dto->description);
        if ($parentTask = $dto->parentTask) {
            $parentTask->addTask($task);
        }
        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }
}
