<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAtotRepository extends IRepository
{
    public function __construct(IAtotModelFacade $eloquent);

    public function findAtotByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
