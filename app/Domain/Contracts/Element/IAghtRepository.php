<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAghtRepository extends IRepository
{
    public function __construct(IAghtModelFacade $eloquent);

    public function findAghtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
