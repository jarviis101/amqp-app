<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\ORM\EntityRepository;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 */
class TaskRepository extends EntityRepository
{

}
