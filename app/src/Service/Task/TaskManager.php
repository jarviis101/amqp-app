<?php

namespace App\Service\Task;

use App\DTO\Task\EditTaskDTO;
use App\Entity\Task;
use App\Exception\InvalidStatusException;
use App\Exception\PriorityAlreadyExist;
use App\Exception\TaskNotFoundException;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class TaskManager
{
    private EntityManagerInterface $em;
    private TaskRepository $repository;

    public function __construct(EntityManagerInterface $em, TaskRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @throws TaskNotFoundException
     * @throws InvalidStatusException
     */
    public function changeStatus(int $id): Task
    {
        if (!$task = $this->repository->find($id)) {
            throw new TaskNotFoundException();
        }

        $this->checkingUndoneSubtasks($task);
        $task->setStatus(!$task->isStatus());

        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }

    /**
     * @throws TaskNotFoundException
     * @throws PriorityAlreadyExist
     */
    public function updateTask(EditTaskDTO $dto, int $id): Task
    {
        if (!$task = $this->repository->find($id)) {
            throw new TaskNotFoundException();
        }

        $task->setTitle($dto->title ?? $task->getTitle());
        $task->setDescription($dto->description ?? $task->getDescription());
        if ($dto->priority) {
            $task->setPriority($dto->priority);
        }
        if (isset($dto->status)) {
            $this->checkingUndoneSubtasks($task);
            $task->setStatus($dto->status);
        }

        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }

    /**
     * @throws InvalidStatusException
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    private function checkingUndoneSubtasks(Task $task) {
        if ($this->repository->hasUndoneSubtasks($task)) {
            throw new InvalidStatusException();
        }
    }
}
