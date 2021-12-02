<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface ITsatRepository extends IRepository
{
    public function __construct(ITsatModelFacade $eloquent);

    public function findTsatByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
