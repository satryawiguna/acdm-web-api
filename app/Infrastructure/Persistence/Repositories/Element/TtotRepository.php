<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class TtotRepository extends BaseRepository implements ITtotRepository
{
    public function __construct(ITtotModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findTtotByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['ttotable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
