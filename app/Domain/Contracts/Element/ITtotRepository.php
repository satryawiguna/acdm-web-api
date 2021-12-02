<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface ITtotRepository extends IRepository
{
    public function __construct(ITtotModelFacade $eloquent);

    public function findTtotByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
