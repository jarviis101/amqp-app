<?php

namespace App\Doctrine\Filter;

use App\Doctrine\Adapter\QueryBuilderFilterInterface;
use Doctrine\ORM\QueryBuilder;

class TitleFilter implements QueryBuilderFilterInterface
{
    use RootAliasTrait;

    public function apply(QueryBuilder $qb, mixed $value): void
    {
        $rootAlias = $this->getRootAlias($qb);

        $qb
            ->andWhere($qb->expr()->like("$rootAlias.title", ":title"))
            ->setParameter('title', "%$value%")
        ;
    }
}
