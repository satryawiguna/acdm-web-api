<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AghtRepository extends BaseRepository implements IAghtRepository
{
    public function __construct(IAghtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAghtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['aghtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
