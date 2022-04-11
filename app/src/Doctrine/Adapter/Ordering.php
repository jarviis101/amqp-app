<?php

namespace App\Doctrine\Adapter;

use App\Doctrine\Filter\RootAliasTrait;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\ORM\QueryBuilder;

class Ordering
{
    use RootAliasTrait;

    private string $field;
    private string $order;

    public function __construct(string $field, string $order)
    {
        $this->field = $field;
        $this->order = $order;
    }

    public function apply(QueryBuilder $qb)
    {
        $qb->addOrderBy(new OrderBy(sprintf('%s.%s', $this->getRootAlias($qb), $this->field), $this->order));
    }
}
