<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class ArztRepository extends BaseRepository implements IArztRepository
{
    public function __construct(IArztModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findArztByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['arztable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
