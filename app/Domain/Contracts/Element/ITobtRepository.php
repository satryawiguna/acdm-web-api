<?php
namespace App\Domain\Contracts\Element;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Element\ITobtModelFacade;
use Illuminate\Support\Collection;

interface ITobtRepository extends IRepository
{
    public function __construct(ITobtModelFacade $eloquent);

    public function findTobt(int $id, array $columns = ['*']): BaseEloquent;

    public function findTobtByDepartureId(int $departureId, array $columns = ['*']): Collection;
}
