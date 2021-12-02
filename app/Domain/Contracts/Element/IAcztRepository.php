<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAcztRepository extends IRepository
{
    public function __construct(IAcztModelFacade $eloquent);

    public function findAcztByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
