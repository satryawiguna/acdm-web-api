<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAzatRepository extends IRepository
{
    public function __construct(IAzatModelFacade $eloquent);

    public function findAzatByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
