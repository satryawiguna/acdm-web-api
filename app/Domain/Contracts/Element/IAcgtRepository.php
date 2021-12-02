<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAcgtRepository extends IRepository
{
    public function __construct(IAcgtModelFacade $eloquent);

    public function findAcgtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
