<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AcztRepository extends BaseRepository implements IAcztRepository
{
    public function __construct(IAcztModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAcztByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['acztable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
