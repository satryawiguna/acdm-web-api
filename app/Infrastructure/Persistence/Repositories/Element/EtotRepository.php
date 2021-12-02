<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class EtotRepository extends BaseRepository implements IEtotRepository
{
    public function __construct(IEtotModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findEtotByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['etotable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
