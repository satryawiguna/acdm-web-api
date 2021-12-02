<?php


namespace App\Core\Domain\Contracts\Pagination;


class ListSearchParameter
{
    public string $search;

    public array $sort;

    /**
     * ListSearchParameter constructor.
     * @param string $search
     * @param array $sort
     */
    public function __construct(string $search, array $sort)
    {
        $this->search = $search;
        $this->sort = $sort;
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
