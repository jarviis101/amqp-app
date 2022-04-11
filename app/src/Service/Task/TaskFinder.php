<?php

namespace App\Service\Task;

use App\Doctrine\Adapter\Ordering;
use App\Doctrine\Adapter\PaginatedSearcher;
use App\Doctrine\Adapter\Traits\QueryBuilderFilterTrait;
use App\DTO\PaginatedResultDTO;
use App\Repository\TaskRepository;

class TaskFinder
{
    use QueryBuilderFilterTrait;

    private const DEFAULT_ORDER_BY = 'createdAt';
    private const DEFAULT_ORDER_MODE = 'desc';

    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findTasks(array $params): PaginatedResultDTO
    {
        $ordering = new Ordering(
            $params['orderBy'] ?? self::DEFAULT_ORDER_BY,
            mb_strtoupper($params['orderMode'] ?? self::DEFAULT_ORDER_MODE)
        );

        $searcher = new PaginatedSearcher($this->repository, $this->filters);
        return $searcher->search(1, 10, $params, [$ordering]);
    }
}
