<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class SobtRepository extends BaseRepository implements ISobtRepository
{
    public function __construct(ISobtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findSobtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['sobtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
