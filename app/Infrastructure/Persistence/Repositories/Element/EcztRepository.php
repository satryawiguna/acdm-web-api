<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class EcztRepository extends BaseRepository implements IEcztRepository
{
    public function __construct(IEcztModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findEcztByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['ecztable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
