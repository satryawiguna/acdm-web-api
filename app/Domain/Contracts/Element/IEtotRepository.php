<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IEtotRepository extends IRepository
{
    public function __construct(IEtotModelFacade $eloquent);

    public function findEtotByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
