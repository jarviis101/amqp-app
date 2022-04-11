<?php

namespace App\Doctrine\Filter;

use App\Doctrine\Adapter\QueryBuilderFilterInterface;
use Doctrine\ORM\QueryBuilder;

class PriorityFilter implements QueryBuilderFilterInterface
{
    use RootAliasTrait;

    public function apply(QueryBuilder $qb, mixed $value): void
    {
        $priority = array_values(explode(",", $value));
        $rootAlias = $this->getRootAlias($qb);
        $qb
            ->andWhere(
                $qb->expr()->in("$rootAlias.priority", ':priorities')
            )
            ->setParameter('priorities', $priority)
        ;
    }
}
