<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IStetRepository extends IRepository
{
    public function __construct(IStetModelFacade $eloquent);

    public function findStetByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
