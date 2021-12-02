<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IStstRepository extends IRepository
{
    public function __construct(IStstModelFacade $eloquent);

    public function findStstByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
