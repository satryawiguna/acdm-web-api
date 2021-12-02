<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class ArdtRepository extends BaseRepository implements IArdtRepository
{
    public function __construct(IArdtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findArdtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['ardtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
