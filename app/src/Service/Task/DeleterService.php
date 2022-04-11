<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Exception\InvalidStatusException;
use App\Exception\TaskNotFoundException;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleterService
{
    private EntityManagerInterface $em;
    private TaskRepository $repository;

    public function __construct(EntityManagerInterface $em, TaskRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @throws InvalidStatusException
     * @throws TaskNotFoundException
     */
    public function delete(int $id)
    {
        if (!$task = $this->repository->find($id)) {
            throw new TaskNotFoundException();
        }
        if ($task->isStatus() === Task::DONE) {
            throw new InvalidStatusException();
        }
        $this->em->remove($task);
        $this->em->flush();
    }
}
