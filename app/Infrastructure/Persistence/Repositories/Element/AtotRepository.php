<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AtotRepository extends BaseRepository implements IAtotRepository
{
    public function __construct(IAtotModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAtotByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['atotable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
