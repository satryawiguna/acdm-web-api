<?php


namespace App\Core\Service\Response;


use Illuminate\Support\Collection;

class GenericPageSearchResponse extends BasicResponse
{
    private Collection $_dtoList;

    public int $totalPage;

    public int $totalCount;


    /**
     * @return int
     */
    public function getTotalPage(): int
    {
        return $this->totalPage;
    }

    /**
     * @param int $totalPage
     */
    public function setTotalPage(int $totalPage): void
    {
        $this->totalPage = $totalPage;
    }

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
