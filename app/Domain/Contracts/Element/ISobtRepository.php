<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface ISobtRepository extends IRepository
{
    public function __construct(ISobtModelFacade $eloquent);

    public function findSobtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
