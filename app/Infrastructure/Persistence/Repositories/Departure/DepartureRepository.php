<?php
namespace App\Infrastructure\Persistence\Repositories\Departure;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Core\Service\Request\DatetimeRangeRequest;
use App\Domain\Contracts\Depature\DateTime;
use App\Domain\Contracts\Depature\IDepartureRepository;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DepartureRepository extends BaseRepository implements IDepartureRepository
{
    public function __construct(IDepartureModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findDeparture(int $id, array $columns = ['*'])
    {
        return $this->_context->fromDepartures()
            ->with(['airport', 'departureMeta'])
            ->findWithoutFail($id, $columns);
    }

    public function findDepartureByAodbId(int $aodbId, array $columns = ['*'])
    {
        return $this->_context->fromDepartures()
            ->with(['airport', 'departureMeta'])
            ->findWhere([
                ['aodb_id', '=', $aodbId]
            ], $columns)->first();
    }

    public function findDepartures(array $ids, array $columns = ['*']): Collection
    {
        return $this->_context->fromDepartures()
            ->with(['airport', 'departureMeta'])
            ->findWhereIn('id', $ids, $columns);
    }

    public function findDeparturesByAodbIds(array $aodbIds, array $columns = ['*']): Collection
    {
        return $this->_context->fromDepartures()
            ->with(['airport', 'departureMeta'])
            ->findWhereIn('aodb_id', $aodbIds, $columns);
    }

    public function findDeparturesListSearch(ListSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $this->_context->fromDepartures()
            ->with(['airport', 'departureMeta'])
            ->findWhereByStatusIsNotTerminated();

        if (!is_null($dateTimeRange)) {
            if (!is_null($filterBy)) {
                $this->_context->findWhereBetweenByField($filterBy, $dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            } else {
                $this->_context->findWhereBetweenByAll($dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            }
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->orderBy($column, $order)
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findDeparturesPageSearch(PageSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): PageSearchResult
    {
//        DB::enableQueryLog();

        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $this->_context->fromDepartures()
            ->with(['airport', 'departureMeta'])
            ->findWhereByStatusIsNotTerminated();

        if (!is_null($dateTimeRange)) {
            if (!is_null($filterBy)) {
                $this->_context->findWhereBetweenByField($filterBy, $dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            } else {
                $this->_context->findWhereBetweenByAll($dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            }
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->orderBy($column, $order)
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

//        var_dump(DB::getQueryLog());
        return $pageSearchResult;
    }

    public function findHistoryDeparturesListSearch(ListSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if (!is_null($dateTimeRange)) {
            if (!is_null($filterBy)) {
                $this->_context->findWhereBetweenByField($filterBy, $dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            } else {
                $this->_context->findWhereBetweenByAll($dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            }
        }

        $this->_context->fromDepartures()
            ->with(['airport']);

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->orderBy($column, $order)
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findHistoryDeparturesPageSearch(PageSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): PageSearchResult
    {
        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if (!is_null($dateTimeRange)) {
            if (!is_null($filterBy)) {
                $this->_context->findWhereBetweenByField($filterBy, $dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            } else {
                $this->_context->findWhereBetweenByAll($dateTimeRange->getStartDate(),
                    $dateTimeRange->getEndDate());
            }
        }

        $this->_context->fromDepartures()
            ->with(['airport']);

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->orderBy($column, $order)
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }

    public function findDepartureTobtsUpdated(DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): Collection
    {
//        DB::enableQueryLog();

        if (!is_null($dateTimeRange)) {
            $this->_context->findWhereBetweenByField('sobt', $dateTimeRange->getStartDate(), $dateTimeRange->getEndDate());
        }

//        dd(DB::getQueryLog());

        return $this->_context->fromDeparturesTobtUpdated()
            ->orderBy('sobt', 'ASC')
            ->all($columns, true);
    }
}
