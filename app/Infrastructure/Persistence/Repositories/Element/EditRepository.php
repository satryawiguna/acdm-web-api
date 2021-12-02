<?php
namespace App\Domain\Contracts\Element;


use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class EditRepository extends BaseRepository implements IEditRepository
{
    public function __construct(IEditModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findEditByDepartureId(int $departureId, array $columns = ['*']): Collection
    {
        return $this->_context->with(['editable'])
            ->findWhere([
            ['departure_id', '=', $departureId]
        ], $columns);
    }
}
