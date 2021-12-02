<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IEobtRepository extends IRepository
{
    public function __construct(IEobtModelFacade $eloquent);

    public function findEobtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
