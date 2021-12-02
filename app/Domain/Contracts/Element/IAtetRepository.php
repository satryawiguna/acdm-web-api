<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAtetRepository extends IRepository
{
    public function __construct(IAtetModelFacade $eloquent);

    public function findAtetByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
