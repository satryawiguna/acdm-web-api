<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class StetRepository extends BaseRepository implements IStetRepository
{
    public function __construct(IStetModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findStetByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['stetable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
