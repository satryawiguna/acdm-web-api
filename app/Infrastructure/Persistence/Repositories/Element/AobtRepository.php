<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AobtRepository extends BaseRepository implements IAobtRepository
{
    public function __construct(IAobtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAobtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['aobtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
