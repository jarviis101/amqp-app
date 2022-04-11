<?php

namespace App\Doctrine\Adapter\Traits;

use App\Doctrine\Adapter\QueryBuilderFilterInterface;

trait QueryBuilderFilterTrait
{
    /**
     * @var QueryBuilderFilterInterface[]
     */
    private array $filters = [];

    public function addFilter(QueryBuilderFilterInterface $filter, string $name): void
    {
        $this->filters[$name] = $filter;
    }
}
