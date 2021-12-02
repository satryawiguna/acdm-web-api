<?php
namespace App\Infrastructure\Persistence\Repositories\Element;


use App\Domain\Contracts\Element\ITobtRepository;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Element\ITobtModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class TobtRepository extends BaseRepository implements ITobtRepository
{
    public function __construct(ITobtModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findTobt(int $id, array $columns = ['*']): BaseEloquent
    {
        return $this->_context->with(['tobtable'])
            ->findWithoutFail($id, $columns);
    }

    public function findTobtByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['tobtable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
