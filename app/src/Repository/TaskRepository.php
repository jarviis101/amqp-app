<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 */
class TaskRepository extends EntityRepository
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function hasUndoneSubtasks(Task $task): bool
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->select('count(t.id)')
            ->innerJoin('t.tasks', 'tt')
            ->andWhere('tt.status = :status')
            ->andWhere('t.id = :id')
            ->setParameters([
                'status' => Task::TODO,
                'id' => $task->getId()
            ]);

        return (int) $qb->getQuery()->getSingleScalarResult() > 0;
    }
}
