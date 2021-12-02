<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AtstRepository extends BaseRepository implements IAtstRepository
{
    public function __construct(IAtstModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAtstByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['atstable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
