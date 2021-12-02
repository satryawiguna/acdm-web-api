<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IEditRepository extends IRepository
{
    public function __construct(IEditModelFacade $eloquent);

    public function findEditByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
