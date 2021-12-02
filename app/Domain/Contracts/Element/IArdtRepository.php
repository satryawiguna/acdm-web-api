<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IArdtRepository extends IRepository
{
    public function __construct(IArdtModelFacade $eloquent);

    public function findArdtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
