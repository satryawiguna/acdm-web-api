<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AcgtRepository extends BaseRepository implements IAcgtRepository
{
    public function __construct(IAcgtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAcgtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['actgtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
