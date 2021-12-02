<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAobtRepository extends IRepository
{
    public function __construct(IAobtModelFacade $eloquent);

    public function findAobtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
