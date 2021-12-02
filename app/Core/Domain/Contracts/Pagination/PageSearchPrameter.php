<?php
namespace App\Core\Domain\Contracts\Pagination;


class PageSearchParameter
{
    public array $pagination;

    public string $search;

    public array $sort;

    /**
     * PageSearchParameter constructor.
     * @param array $pagination
     * @param string $search
     * @param array $sort
     */
    public function __construct(array $pagination, string $search, array $sort)
    {
        $this->pagination = $pagination;
        $this->search = $search;
        $this->sort = $sort;
    }

    /**
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }

    /**
     * @param array $pagination
     */
    public function setPagination(array $pagination): void
    {
        $this->pagination = $pagination;
    }

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    /**
     * @return array
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * @param array $sort
     */
    public function setSort(array $sort): void
    {
        $this->sort = $sort;
    }
}
