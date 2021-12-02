<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAxotRepository extends IRepository
{
    public function __construct(IAxotModelFacade $eloquent);

    public function findAxotByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
