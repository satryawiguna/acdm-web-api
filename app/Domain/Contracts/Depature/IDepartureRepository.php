<?php
namespace App\Domain\Contracts\Depature;


use App\Core\Domain\Contracts\IRepository;
use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Core\Service\Request\DatetimeRangeRequest;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureModelFacade;
use Illuminate\Support\Collection;


interface IDepartureRepository extends IRepository
{
    public function __construct(IDepartureModelFacade $eloquent);

    public function findDeparture(int $id, array $columns = ['*']);

    public function findDepartureByAodbId(int $aodbId, array $columns = ['*']);

    public function findDepartures(array $ids, array $columns = ['*']): Collection;

    public function findDeparturesByAodbIds(array $aodbIds, array $columns = ['*']): Collection;

    public function findDeparturesListSearch(ListSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): ListSearchResult;

    public function findDeparturesPageSearch(PageSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): PageSearchResult;

    public function findHistoryDeparturesListSearch(ListSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): ListSearchResult;

    public function findHistoryDeparturesPageSearch(PageSearchParameter $parameter, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): PageSearchResult;

    public function findDepartureTobtsUpdated(DatetimeRangeRequest $dateTimeRange = null, array $columns = ['*']): Collection;
}
