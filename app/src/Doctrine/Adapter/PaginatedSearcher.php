<?php

namespace App\Doctrine\Adapter;

use App\DTO\PaginatedResultDTO;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;

class PaginatedSearcher
{
    private EntityRepository $repository;
    /**
     * @var QueryBuilderFilterInterface[]
     */
    private array $filters;

    public function __construct(EntityRepository $repository, array $filters)
    {
        $this->repository = $repository;
        $this->filters = $filters;
    }

    /**
     * @throws Exception
     */
    public function search(int $page, int $itemsPerPage, array $searchCriteria, array $ordering = []): PaginatedResultDTO
    {
        $searchCriteria = array_filter($searchCriteria, function ($value) {
            return '' !== $value;
        });
        $qb = $this->repository->createQueryBuilder('entity');

        foreach ($searchCriteria as $name => $value) {
            if (true === array_key_exists($name, $this->filters)) {
                $this->filters[$name]->apply($qb, $value);
            }
        }

        foreach ($ordering as $order) {
            $order->apply($qb);
        }

        $qb->setMaxResults($itemsPerPage);
        $qb->setFirstResult($itemsPerPage * ($page - 1));
        $paginator = new Paginator($qb->getQuery());
        $pages = $paginator->count() === 0 ? 1 : ceil($paginator->count() / $itemsPerPage);

        return new PaginatedResultDTO(
            $page,
            $itemsPerPage,
            $pages,
            $paginator->count(),
            iterator_to_array($paginator->getIterator())
        );
    }
}
