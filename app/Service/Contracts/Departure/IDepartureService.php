<?php
namespace App\Service\Contracts\Departure;


use App\Core\Service\Request\DatetimeRangeRequest;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Service\Contracts\Departure\Request\CreateDepartureRequest;
use App\Service\Contracts\Departure\Request\CreateFlightInformationRequest;
use App\Service\Contracts\Departure\Request\UpdateDepartureRequest;
use Illuminate\Support\Collection;

interface IDepartureService
{
    public function showDeparture(int $id, array $columns = ['*']): GenericObjectResponse;

    public function showDepartureByAodbId(int $aodbId, array $columns = ['*']): GenericObjectResponse;

    public function getDepartures(array $ids = null, array $columns = ['*']): GenericCollectionResponse;

    public function getDeparturesByAodbIds(array $aodbIds = null, array $columns = ['*']): GenericCollectionResponse;

    public function getDeparturesListSearch(ListSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericListSearchResponse;

    public function getDeparturesPageSearch(PageSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericPageSearchResponse;

    public function getHistoryDeparturesListSearch(ListSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericListSearchResponse;

    public function getHistoryDeparturesPageSearch(PageSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericPageSearchResponse;

    public function getDepartureTobtsUpdated(DatetimeRangeRequest $dateTimeRange = null): GenericObjectResponse;

    public function createDeparture(CreateDepartureRequest $request): GenericObjectResponse;

    public function createDepartures(Collection $requests): GenericCollectionResponse;

    public function updateDeparture(UpdateDepartureRequest $request): GenericObjectResponse;

    public function updateDepartures(Collection $requests): GenericCollectionResponse;
}
