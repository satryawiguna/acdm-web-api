<?php
namespace App\Service\Contracts\MasterData;


use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\IntegerResponse;
use App\Service\Contracts\MasterData\Request\CreateAirlineRequest;
use App\Service\Contracts\MasterData\Request\CreateAirportRequest;
use App\Service\Contracts\MasterData\Request\CreateCountryRequest;
use App\Service\Contracts\MasterData\Request\CreateOrganizationRequest;
use App\Service\Contracts\MasterData\Request\CreateVendorRequest;
use App\Service\Contracts\MasterData\Request\UpdateAirlineRequest;
use App\Service\Contracts\MasterData\Request\UpdateAirportRequest;
use App\Service\Contracts\MasterData\Request\UpdateCountryRequest;
use App\Service\Contracts\MasterData\Request\UpdateOrganizationRequest;
use App\Service\Contracts\MasterData\Request\UpdateVendorRequest;
use Illuminate\Support\Collection;


interface IMasterDataService
{
    public function getAirports(): GenericCollectionResponse;

    public function getAirportsListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getAirportsPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createAirport(CreateAirportRequest $request): GenericObjectResponse;

    public function createAirports(Collection $requests): GenericCollectionResponse;

    public function showAirport(int $id): GenericObjectResponse;

    public function showAirportByIata(string $iata): GenericCollectionResponse;

    public function showAirportByIcao(string $icao): GenericCollectionResponse;

    public function updateAirport(UpdateAirportRequest $request): GenericObjectResponse;

    public function updateAirports(Collection $requests): GenericCollectionResponse;

    public function destroyAirport(int $id): IntegerResponse;

    public function destroyAirports(array $ids): BasicResponse;

    public function findAirportByIata(string $iata): GenericObjectResponse;

    public function findAirportByIcao(string $icao): GenericObjectResponse;

    public function getSlugAirport(string $name): GenericObjectResponse;


    public function getAirlines(): GenericCollectionResponse;

    public function getAirlinesListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getAirlinesPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createAirline(CreateAirlineRequest $request): GenericObjectResponse;

    public function showAirline(int $id): GenericObjectResponse;

    public function updateAirline(UpdateAirlineRequest $request): GenericObjectResponse;

    public function destroyAirline(int $id): IntegerResponse;

    public function destroyAirlines(array $ids): BasicResponse;

    public function getSlugAirline(string $name): GenericObjectResponse;


    public function getVendors(): GenericCollectionResponse;

    public function getVendorsListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getVendorsPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createVendor(CreateVendorRequest $request): GenericObjectResponse;

    public function createVendors(Collection $requests): GenericCollectionResponse;

    public function showVendor(int $id): GenericObjectResponse;

    public function updateVendor(UpdateVendorRequest $request): GenericObjectResponse;

    public function updateVendors(Collection $requests): GenericCollectionResponse;

    public function destroyVendor(int $id): IntegerResponse;

    public function destroyVendors(array $ids): BasicResponse;

    public function getSlugVendor(string $name): GenericObjectResponse;


    public function getOrganizations(): GenericCollectionResponse;

    public function getOrganizationsListSearch(ListSearchRequest $request, int $countryId = null): GenericListSearchResponse;

    public function getOrganizationsPageSearch(PageSearchRequest $request, int $countryId = null): GenericPageSearchResponse;

    public function createOrganization(CreateOrganizationRequest $request): GenericObjectResponse;

    public function showOrganization(int $id): GenericObjectResponse;

    public function updateOrganization(UpdateOrganizationRequest $request): GenericObjectResponse;

    public function destroyOrganization(int $id): IntegerResponse;

    public function getSlugOrganization(string $name): GenericObjectResponse;


    public function getCountries(): GenericCollectionResponse;

    public function getCountriesListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getCountriesPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createCountry(CreateCountryRequest $request): GenericObjectResponse;

    public function showCountry(int $id): GenericObjectResponse;

    public function updateCountry(UpdateCountryRequest $request): GenericObjectResponse;

    public function destroyCountry(int $id): IntegerResponse;

    public function getSlugCountry(string $name): GenericObjectResponse;
}
