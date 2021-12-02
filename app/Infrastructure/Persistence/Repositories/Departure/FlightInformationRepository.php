<?php


namespace App\Infrastructure\Persistence\Repositories\Departure;


use App\Domain\Contracts\Depature\IFlightInformationRepository;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IFlightInformationModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class FlightInformationRepository extends BaseRepository implements IFlightInformationRepository
{
    public function __construct(IFlightInformationModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findLatestFlightInformationByDepartureId(int $departureId, array $column = ['*'])
    {
        $model = $this->_context->findWhere([
            ['departure_id', '=', $departureId]
        ], $column);

        return $model->last() ?? new \stdClass();
    }
}
