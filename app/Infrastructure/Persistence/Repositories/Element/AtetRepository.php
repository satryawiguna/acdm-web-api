<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AtetRepository extends BaseRepository implements IAtetRepository
{
    public function __construct(IAtetModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAtetByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['atetable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
