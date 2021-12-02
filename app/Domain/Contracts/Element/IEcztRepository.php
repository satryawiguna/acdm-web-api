<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IEcztRepository extends IRepository
{
    public function __construct(IEcztModelFacade $eloquent);

    public function findEcztByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
