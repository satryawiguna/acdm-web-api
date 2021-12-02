<?php


namespace App\Core\Domain\Contracts\Pagination;


use Illuminate\Support\Collection;

class PageSearchResult
{
    private Collection $_result;

    public int $count;

    public Collection $result;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return Collection
     */
    public function getResult(): Collection
    {
        return $this->_result ?? ($this->_result = new Collection());
    }
}
