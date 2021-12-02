<?php


namespace App\Core\Service\Request;


class IntegerRangeRequest
{
    private int $startValue;

    private int $endValue;

    public function __construct(int $startValue, int $endValue)
    {
        $this->startValue = $startValue;

        $this->endValue = $endValue;
    }

    /**
     * @return int
     */
    public function getStartValue(): int
    {
        return $this->startValue;
    }

    /**
     * @param int $startValue
     */
    public function setStartValue(int $startValue): void
    {
        $this->startValue = $startValue;
    }

    /**
     * @return int
     */
    public function getEndValue(): int
    {
        return $this->endValue;
    }

    /**
     * @param int $endValue
     */
    public function setEndValue(int $endValue): void
    {
        $this->endValue = $endValue;
    }
}
