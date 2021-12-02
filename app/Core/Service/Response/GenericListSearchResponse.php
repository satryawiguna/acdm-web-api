<?php
namespace App\Core\Service\Response;


use Illuminate\Support\Collection;

class GenericListSearchResponse
{
    private Collection $_dtoList;

    public int $totalCount;


    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount(int $totalCount): void
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return Collection
     */
    public function dtoCollection(): Collection
    {
        return $this->_dtoList ?? ($this->_dtoList = new Collection());
    }
}
