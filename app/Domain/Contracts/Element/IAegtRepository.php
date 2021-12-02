<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAegtRepository extends IRepository
{
    public function __construct(IAegtModelFacade $eloquent);

    public function findAegtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
