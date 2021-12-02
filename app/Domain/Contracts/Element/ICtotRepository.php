<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface ICtotRepository extends IRepository
{
    public function __construct(ICtotModelFacade $eloquent);

    public function findCtotByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
