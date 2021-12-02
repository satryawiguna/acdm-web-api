<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAtstRepository extends IRepository
{
    public function __construct(IAtstModelFacade $eloquent);

    public function findAtstByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
