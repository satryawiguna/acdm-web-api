<?php


namespace App\Core\Service\Request;


use DateTime;

class DatetimeRangeRequest
{
    private DateTime $startDate;

    private DateTime $endDate;

    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        $this->startDate = $startDate;

        $this->endDate = $endDate;
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }
}
