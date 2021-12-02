<?php


namespace App\Infrastructure\Persistence\ModelFacades\Departure;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IFlightInformationModelFacade;

class FlightInformationModelFacade extends BaseModelFacade implements IFlightInformationModelFacade
{
    public function findWhereByType(string $type)
    {
        $this->model = $this->model->where('type', '=', $type);

        return $this;
    }
}
