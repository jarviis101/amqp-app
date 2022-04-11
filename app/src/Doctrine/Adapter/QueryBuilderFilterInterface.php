<?php

namespace App\Doctrine\Adapter;

use Doctrine\ORM\QueryBuilder;

interface QueryBuilderFilterInterface
{
    public function apply(QueryBuilder $qb, mixed $value): void;
}
