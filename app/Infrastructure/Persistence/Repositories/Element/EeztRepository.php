<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class EeztRepository extends BaseRepository implements IEeztRepository
{
    public function __construct(IEeztModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findEeztByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['eeztable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
