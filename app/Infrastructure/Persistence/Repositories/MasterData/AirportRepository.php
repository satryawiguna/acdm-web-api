<?php
namespace App\Infrastructure\Persistence\Repositories\MasterData;


use App\Domain\Contracts\MasterData\IAirportRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirportModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AirportRepository extends BaseRepository implements IAirportRepository
{
    public function __construct(IAirportModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAirportsByIds(array $ids, array $columns = ['*']): Collection
    {
        return $this->_context->findWhereIn('id', $ids, $columns);
    }
}
