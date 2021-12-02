<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AxotRepository extends BaseRepository implements IAxotRepository
{
    public function __construct(IAxotModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAxotByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['axotable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
