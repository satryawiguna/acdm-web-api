<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class ExotRepository extends BaseRepository implements IExotRepository
{
    public function __construct(IExotModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findExotByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['exotable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
