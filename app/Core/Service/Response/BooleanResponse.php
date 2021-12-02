<?php


namespace App\Core\Service\Response;


class BooleanResponse extends BasicResponse
{
    public bool $result;

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @param bool $result
     */
    public function setResult(bool $result): void
    {
        $this->result = $result;
    }
}
