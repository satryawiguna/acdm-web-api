<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AsrtRepository extends BaseRepository implements IAsrtRepository
{
    public function __construct(IAsrtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAsrtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['asrtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
