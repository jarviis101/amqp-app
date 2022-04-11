<?php

namespace App\DTOBuilder\Task;

use App\DTO\Task\TaskDTO;
use App\Entity\Task;

class TaskBuilder
{
    public function build(Task $task): TaskDTO
    {
        $dto = new TaskDTO($task->getId(), $task->getTitle(), $task->getDescription());
        $dto->status = $task->isStatus() ? 'done' : 'todo';
        $dto->priority = $task->getPriority()->getLevel();
        $dto->createdAt = $task->getCreatedAt();
        $dto->subtasks = $task->getTasks()->map(function (Task $task) {
            return new TaskDTO($task->getId(), $task->getTitle(), $task->getDescription());
        })->toArray();

        return $dto;
    }
}
