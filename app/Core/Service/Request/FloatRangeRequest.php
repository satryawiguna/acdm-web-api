<?php


namespace App\Core\Service\Request;


class FloatRangeRequest
{
    private float $startValue;

    private float $endValue;

    public function __construct(float $startValue, float $endValue)
    {
        $this->startValue = $startValue;

        $this->endValue = $endValue;
    }

    /**
     * @return float
     */
    public function getStartValue(): float
    {
        return $this->startValue;
    }

    /**
     * @param float $startValue
     */
    public function setStartValue(float $startValue): void
    {
        $this->startValue = $startValue;
    }

    /**
     * @return float
     */
    public function getEndValue(): float
    {
        return $this->endValue;
    }

    /**
     * @param float $endValue
     */
    public function setEndValue(float $endValue): void
    {
        $this->endValue = $endValue;
    }
}
