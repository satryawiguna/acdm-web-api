<?php


namespace App\Domain\Contracts\Depature;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IFlightInformationModelFacade;

interface IFlightInformationRepository extends IRepository
{
    public function __construct(IFlightInformationModelFacade $eloquent);

    public function findLatestFlightInformationByDepartureId(int $departureId, array $column = ['*']);
}
