<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class TsatRepository extends BaseRepository implements ITsatRepository
{
    public function __construct(ITsatModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findTsatByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['tsatable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
