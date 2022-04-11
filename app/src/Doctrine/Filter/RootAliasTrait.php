<?php
namespace App\Doctrine\Filter;

use Doctrine\ORM\QueryBuilder;

trait RootAliasTrait
{
    private function getRootAlias(QueryBuilder $queryBuilder): string
    {
        return $queryBuilder->getRootAliases()[0];
    }
}
