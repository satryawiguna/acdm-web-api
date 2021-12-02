<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AzatRepository extends BaseRepository implements IAzatRepository
{
    public function __construct(IAzatModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAzatByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['azatable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
