<?php
namespace App\Core\Service\Request;


class PageSearchRequest
{
    public array $pagination;

    public string $search;

    public array $sort;

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
