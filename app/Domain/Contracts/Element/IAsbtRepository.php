<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAsbtRepository extends IRepository
{
    public function __construct(IAsbtModelFacade $eloquent);

    public function findAsbtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
