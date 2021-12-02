<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class StstRepository extends BaseRepository implements IStstRepository
{
    public function __construct(IStstModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findStstByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['ststable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
