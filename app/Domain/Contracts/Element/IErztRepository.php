<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use Illuminate\Support\Collection;

interface IErztRepository extends IRepository
{
    public function __construct(IErztModelFacade $eloquent);

    public function findErztByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
