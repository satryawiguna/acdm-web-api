<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IExotRepository extends IRepository
{
    public function __construct(IExotModelFacade $eloquent);

    public function findExotByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
