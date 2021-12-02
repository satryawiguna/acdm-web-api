<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IArztRepository extends IRepository
{
    public function __construct(IArztModelFacade $eloquent);

    public function findArztByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
