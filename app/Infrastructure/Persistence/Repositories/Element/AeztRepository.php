<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AeztRepository extends BaseRepository implements IAeztRepository
{
    public function __construct(IAeztModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAeztByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['aeztable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
