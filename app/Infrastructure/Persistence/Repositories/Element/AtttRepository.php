<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AtttRepository extends BaseRepository implements IAtttRepository
{
    public function __construct(IAtttModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findAtttByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['atttable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
