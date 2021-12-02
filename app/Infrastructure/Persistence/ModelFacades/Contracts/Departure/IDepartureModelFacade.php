<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\Departure;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;
use DateTime;

interface IDepartureModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);

    public function fromDepartures();

    public function fromDeparturesTobtUpdated();

    public function findWhereByStatusIsNotTerminated();

    public function findWhereBetweenByAll(DateTime $start, DateTime $end);

    public function findWhereBetweenByField(string $field, DateTime $start, DateTime $end);
}
