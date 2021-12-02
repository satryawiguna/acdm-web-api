<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AegtRepository extends BaseRepository implements IAegtRepository
{
    public function __construct(IAegtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAegtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['aegtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
