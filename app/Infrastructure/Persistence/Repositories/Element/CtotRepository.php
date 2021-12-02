<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class CtotRepository extends BaseRepository implements ICtotRepository
{
    public function __construct(ICtotModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findCtotByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['ctotable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
