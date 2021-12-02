<?php
namespace App\Domain\Contracts\MasterData;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirportModelFacade;
use Illuminate\Support\Collection;

interface IAirportRepository extends IRepository
{
    public function __construct(IAirportModelFacade $eloquent);

    public function findAirportsByIds(array $ids, array $columns = ['*']): Collection;
}
