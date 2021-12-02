<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class ErztRepository extends BaseRepository implements IErztRepository
{
    public function __construct(IErztModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findErztByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['erztable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
