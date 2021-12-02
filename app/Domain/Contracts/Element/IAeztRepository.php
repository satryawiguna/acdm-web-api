<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAeztRepository extends IRepository
{
    public function __construct(IAeztModelFacade $eloquent);

    public function findAeztByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
