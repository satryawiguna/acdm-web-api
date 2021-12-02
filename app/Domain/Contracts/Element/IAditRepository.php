<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAditRepository extends IRepository
{
    public function __construct(IAditModelFacade $eloquent);

    public function findAditByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
