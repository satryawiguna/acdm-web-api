<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class EobtRepository extends BaseRepository implements IEobtRepository
{
    public function __construct(IEobtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findEobtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['eobtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
