<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAsrtRepository extends IRepository
{
    public function __construct(IAsrtModelFacade $eloquent);

    public function findAsrtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
