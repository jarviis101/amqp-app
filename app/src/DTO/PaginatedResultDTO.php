<?php

namespace App\DTO;

use JMS\Serializer\Annotation as JMS;

class PaginatedResultDTO
{
    /**
     * @JMS\Type("integer")
     */
    private int $page;

    /**
     * @JMS\Type("integer")
     */
    private int $itemsPerPage;

    /**
     * @JMS\Type("integer")
     */
    private int $pages;

    /**
     * @JMS\Type("integer")
     */
    private int $count;

    /**
     * @JMS\Type("array")
     */
    private array $items = [];

    public function __construct(int $page, int $itemsPerPage, int $pages, int $count, array $items)
    {
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->pages = $pages;
        $this->count = $count;
        $this->items = $items;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function toArray(callable $callback): array
    {
        return [
            'page' => $this->getPage(),
            'itemsPerPage' => $this->getItemsPerPage(),
            'pages' => $this->getPages(),
            'count' => $this->getCount(),
            'items' => array_map($callback, $this->getItems())
        ];
    }
}
