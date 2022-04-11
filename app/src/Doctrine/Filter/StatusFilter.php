<?php

namespace App\Doctrine\Filter;

use App\Doctrine\Adapter\QueryBuilderFilterInterface;
use Doctrine\ORM\QueryBuilder;

class StatusFilter implements QueryBuilderFilterInterface
{
    use RootAliasTrait;

    public function apply(QueryBuilder $qb, mixed $value): void
    {
        $rootAlias = $this->getRootAlias($qb);

        $qb
            ->andWhere("$rootAlias.status = :status", $rootAlias)
            ->setParameter('status', $value)
        ;
    }
}
