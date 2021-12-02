<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IAtttRepository extends IRepository
{
    public function __construct(IAtttModelFacade $eloquent);

    public function findAtttByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
