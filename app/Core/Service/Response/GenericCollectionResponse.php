<?php


namespace App\Core\Service\Response;


use Illuminate\Support\Collection;

class GenericCollectionResponse extends BasicResponse
{
    private Collection $_dtoList;


    /**
     * @return Collection
     */
    public function dtoCollection(): Collection
    {
        return $this->_dtoList ?? ($this->_dtoList = new Collection());
    }
}
