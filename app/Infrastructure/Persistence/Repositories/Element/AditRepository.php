<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AditRepository extends BaseRepository implements IAditRepository
{
    public function __construct(IAditModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAditByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['aditable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
