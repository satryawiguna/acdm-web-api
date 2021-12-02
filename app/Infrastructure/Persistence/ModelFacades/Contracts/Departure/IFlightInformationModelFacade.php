<?php


namespace App\Infrastructure\Persistence\ModelFacades\Contracts\Departure;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IFlightInformationModelFacade extends IModelFacade
{
    public function findWhereByType(string $type);
}
