<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IEeztRepository extends IRepository
{
    public function __construct(IEeztModelFacade $eloquent);

    public function findEeztByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
