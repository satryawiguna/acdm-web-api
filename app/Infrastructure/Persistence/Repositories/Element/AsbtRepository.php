<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AsbtRepository extends BaseRepository implements IAsbtRepository
{
    public function __construct(IAsbtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAsbtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['asbtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
