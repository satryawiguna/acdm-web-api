<?php


namespace App\Core\Service\Response;


class GenericObjectResponse extends BasicResponse
{
    public object $dto;

    /**
     * @return object
     */
    public function getDto(): object
    {
        return $this->dto;
    }

    /**
     * @param object $dto
     */
    public function setDto(object $dto): void
    {
        $this->dto = $dto;
    }
}
