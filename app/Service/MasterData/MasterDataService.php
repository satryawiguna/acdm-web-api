<?php
namespace App\Service\MasterData;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\IntegerResponse;
use App\Domain\Contracts\MasterData\IAirlineRepository;
use App\Domain\Contracts\MasterData\IAirportRepository;
use App\Domain\Contracts\MasterData\ICountryRepository;
use App\Domain\Contracts\MasterData\IOrganizationRepository;
use App\Domain\Contracts\MasterData\IVendorRepository;
use App\Domain\MasterData\AirlineEloquent;
use App\Domain\MasterData\AirportEloquent;
use App\Domain\MasterData\CountryEloquent;
use App\Domain\MasterData\OrganizationEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Service\BaseService;
use App\Service\Contracts\MasterData\IMasterDataService;
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
use Illuminate\Validation\Rule;

class MasterDataService extends BaseService implements IMasterDataService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IAirportRepository $_airportRepository;
    private IAirlineRepository $_airlineRepository;
    private IVendorRepository $_vendorRepository;
    private ICountryRepository $_countryRepository;
    private IOrganizationRepository $_organizationRepository;

    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IAirportRepository $airportRepository,
                                IAirlineRepository $airlineRepository,
                                IVendorRepository $vendorRepository,
                                ICountryRepository $countryRepository,
                                IOrganizationRepository $organizationRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;
        $this->_airportRepository = $airportRepository;
        $this->_airlineRepository = $airlineRepository;
        $this->_vendorRepository = $vendorRepository;
        $this->_countryRepository = $countryRepository;
        $this->_organizationRepository = $organizationRepository;
    }

    public function getAirports(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_airportRepository, 'allWithChunk']
        );
    }

    public function getAirportsListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_airportRepository, 'listSearchWithChunk'],
            $request
        );
    }

    public function getAirportsPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_airportRepository, 'pageSearch'],
            $request
        );
    }

    public function createAirport(CreateAirportRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $airport = $this->_airportRepository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "location" => $request->location,
                "country" => $request->country,
                "icao" => $request->icao,
                "iata" => $request->iata
            ]);

            $this->setAuditableInformationFromRequest($airport, $request);

            $rules = [
                'name' => 'string|max:255|nullable',
                'slug' => 'string|max:255|unique:airports|nullable',
                'location' => 'string|max:255|nullable',
                'country' => 'string|max:255|nullable',
                'icao' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                    return $query->where('location', $request->location)
                        ->where('icao', $request->icao);
                })],
                'iata' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                    return $query->where('location', $request->location)
                        ->where('iata', $request->iata);
                })]
            ];

            $brokenRules = $airport->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $airportResult = $unitOfWork->markNewAndSaveChange($this->_airportRepository, $airport);

            $response->dto = $airportResult;
            $response->addInfoMessageResponse('Airport created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function createAirports(Collection $requests): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $requests->each(function($request, $key) use($response, $unitOfWork) {
                $airport = $this->_airportRepository->newInstance([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "location" => $request->location,
                    "country" => $request->country,
                    "icao" => $request->icao,
                    "iata" => $request->iata
                ]);

                $this->setAuditableInformationFromRequest($airport, $request);

                $rules = [
                    'name' => 'string|max:255|nullable',
                    'slug' => 'string|max:255|unique:airports|nullable',
                    'location' => 'string|max:255|nullable',
                    'country' => 'string|max:255|nullable',
                    'icao' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                        return $query->where('location', $request->location)
                            ->where('icao', $request->icao);
                    })],
                    'iata' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                        return $query->where('location', $request->location)
                            ->where('iata', $request->iata);
                    })]
                ];

                $brokenRules = $airport->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $airportResult = $unitOfWork->markNewAndSaveChange($this->_airportRepository, $airport);

                $response->dtoCollection()->push($airportResult);
            });

            $response->addInfoMessageResponse('Airports created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showAirport(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_airportRepository, 'find'],
            [$id]
        );
    }

    public function showAirportByIata(string $iata): GenericCollectionResponse
    {
        return $this->search(
            [$this->_airportRepository, 'findWhere'],
            ['where' => [['iata', 'LIKE', '%' . $iata . '%']]]
        );
    }

    public function showAirportByIcao(string $icao): GenericCollectionResponse
    {
        return $this->search(
            [$this->_airportRepository, 'findWhere'],
            ['where' => [['icao', 'LIKE', '%' . $icao . '%']]]
        );
    }

    public function updateAirport(UpdateAirportRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $airport = $this->_airportRepository->find($request->id);

            if ($airport) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $airport->fill([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "location" => $request->location,
                    "country" => $request->country,
                    "icao" => $request->icao,
                    "iata" => $request->iata,
                ]);

                $this->setAuditableInformationFromRequest($airport, $request);

                $rules = [
                    'name' => 'string|max:255|nullable',
                    'slug' => 'string|max:255|unique:airports|nullable',
                    'location' => 'string|max:255|nullable',
                    'country' => 'string|max:255|nullable',
                    'icao' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                        return $query->where('location', $request->location)
                            ->where('country', $request->country);
                    })],
                    'iata' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                        return $query->where('location', $request->location)
                            ->where('country', $request->country);
                    })]
                ];

                $brokenRules = $airport->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $airportResult = $unitOfWork->markDirtyAndSaveChange($this->_airportRepository, $airport);

                $response->dto = $airportResult;
                $response->addInfoMessageResponse('Airport updated');

                return $response;
            }

            $response->addErrorMessageResponse('Airport not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateAirports(Collection $requests): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $requests->each(function($request, $key) use($response, $unitOfWork) {
                $airport = $this->_airportRepository->find($request->id);

                if ($airport) {
                    $airport->fill([
                        "name" => $request->name,
                        "slug" => $request->slug,
                        "location" => $request->location,
                        "country" => $request->country,
                        "icao" => $request->icao,
                        "iata" => $request->iata
                    ]);

                    $this->setAuditableInformationFromRequest($airport, $request);

                    $rules = [
                        'name' => 'string|max:255|nullable',
                        'slug' => 'string|max:255|unique:airports|nullable',
                        'location' => 'string|max:255|nullable',
                        'country' => 'string|max:255|nullable',
                        'icao' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                            return $query->where('location', $request->location)
                                ->where('icao', $request->icao);
                        })],
                        'iata' => ['string', 'max:255', 'nullable', Rule::unique('airports')->where(function($query) use($request) {
                            return $query->where('location', $request->location)
                                ->where('iata', $request->iata);
                        })]
                    ];

                    $brokenRules = $airport->validate($rules, $request);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                            foreach ($value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }

                    $airportResult = $unitOfWork->markDirtyAndSaveChange($this->_airportRepository, $airport);

                    $response->dtoCollection()->push($airportResult);
                }
            });

            $response->addInfoMessageResponse('Airports updated');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyAirport(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $airport = $this->_airportRepository->find($id);

            if ($airport) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $airportResult = $unitOfWork->markRemoveAndSaveChange($this->_airportRepository, $airport);

                $response->result = $airportResult;

                return $response;
            }

            $response->addErrorMessageResponse('Airport not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyAirports(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $airport = $this->_airportRepository->find($id);

                if ($airport) {
                    $unitOfWork->markRemove($this->_airportRepository, $airport);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Airports deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function findAirportByIata(string $iata): GenericObjectResponse
    {
        return $this->read(
            [$this->_airportRepository, 'findWhere'],
            [
                ['iata', '=', $iata]
            ]
        );
    }

    public function findAirportByIcao(string $icao): GenericObjectResponse
    {
        return $this->read(
            [$this->_airportRepository, 'findWhere'],
            [
                ['icao', '=', $icao]
            ]
        );
    }

    public function getSlugAirport(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(AirportEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAirlines(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_airlineRepository, 'all']
        );
    }

    public function getAirlinesListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_airlineRepository, 'listSearch'],
            $request
        );
    }

    public function getAirlinesPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_airlineRepository, 'pageSearch'],
            $request
        );
    }

    public function createAirline(CreateAirlineRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $airline = $this->_airlineRepository->newInstance([
                "flight_number" => $request->flight_number,
                "name" => $request->name,
                "slug" => $request->slug,
                "icao" => $request->icao,
                "iata" => $request->iata,
                "call_sign" => $request->call_sign,
            ]);

            $this->setAuditableInformationFromRequest($airline, $request);

            $rules = [
                'flight_number' => 'string|max:255|nullable',
                'name' => 'string|max:255|nullable',
                'slug' => 'string|max:255|unique:airlines|nullable',
                'icao' => ['string', 'max:255', 'nullable', Rule::unique('airlines')->where(function($query) use($request) {
                    return $query->where('flight_number', $request->flight_number)
                        ->where('icao', $request->icao);
                })],
                'iata' => ['string', 'max:255', 'nullable', Rule::unique('airlines')->where(function($query) use($request) {
                    return $query->where('flight_number', $request->flight_number)
                        ->where('iata', $request->iata);
                })],
                'call_sign' => 'string|max:255|nullable',
            ];

            $brokenRules = $airline->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $airlineResult = $unitOfWork->markNewAndSaveChange($this->_airlineRepository, $airline);

            $response->dto = $airlineResult;
            $response->addInfoMessageResponse('Airline created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showAirline(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_airlineRepository, 'find'],
            [$id]
        );
    }

    public function updateAirline(UpdateAirlineRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $airline = $this->_airlineRepository->find($request->id);

            if ($airline) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $airline->fill([
                    "flight_number" => $request->flight_number,
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "icao" => $request->icao,
                    "iata" => $request->iata,
                    "call_sign" => $request->call_sign,
                ]);

                $this->setAuditableInformationFromRequest($airline, $request);

                $rules = [
                    'flight_number' => 'string|max:255|nullable',
                    'name' => 'required|string|max:255|nullable',
                    'slug' => 'required|string|max:255|unique:airlines|nullable',
                    'icao' => ['string', 'max:255', 'nullable', Rule::unique('airlines')->where(function($query) use($request) {
                        return $query->where('flight_number', $request->flight_number)
                            ->where('icao', $request->icao);
                    })],
                    'iata' => ['string', 'max:255', 'nullable', Rule::unique('airlines')->where(function($query) use($request) {
                        return $query->where('flight_number', $request->flight_number)
                            ->where('iata', $request->iata);
                    })],
                    'call_sign' => 'string|max:255|nullable',
                ];

                $brokenRules = $airline->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $airlineResult = $unitOfWork->markDirtyAndSaveChange($this->_airlineRepository, $airline);

                $response->dto = $airlineResult;
                $response->addInfoMessageResponse('Airline updated');

                return $response;
            }

            $response->addErrorMessageResponse('Airline not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyAirline(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $airline = $this->_airlineRepository->find($id);

            if ($airline) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $airlineResult = $unitOfWork->markRemoveAndSaveChange($this->_airlineRepository, $airline);

                $response->result = $airlineResult;

                return $response;
            }

            $response->addErrorMessageResponse('Airline not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyAirlines(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $airline = $this->_airlineRepository->find($id);

                if ($airline) {
                    $unitOfWork->markRemove($this->_airlineRepository, $airline);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Airlines deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugAirline(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(AirlineEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }



    public function getVendors(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_vendorRepository, 'all']
        );
    }

    public function getVendorsListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_vendorRepository, 'listSearch'],
            $request
        );
    }

    public function getVendorsPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_vendorRepository, 'pageSearch'],
            $request
        );
    }

    public function createVendor(CreateVendorRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $vendor = $this->_vendorRepository->newInstance([
                "role_id" => $request->role_id,
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description
            ]);

            $this->setAuditableInformationFromRequest($vendor, $request);

            $rules = [
                'role_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255'
            ];

            $brokenRules = $vendor->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $vendorResult = $unitOfWork->markNewAndSaveChange($this->_vendorRepository, $vendor);

            $response->dto = $vendorResult;
            $response->addInfoMessageResponse('Vendor created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function createVendors(Collection $requests): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $requests->each(function($request, $key) use($response, $unitOfWork) {
                $vendor = $this->_vendorRepository->newInstance([
                    "role_id" => $request->role_id,
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($vendor, $request);

                $rules = [
                    'role_id' => 'required|integer',
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255'
                ];

                $brokenRules = $vendor->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                        foreach ($_value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $vendorResult = $unitOfWork->markNewAndSaveChange($this->_vendorRepository, $vendor);

                $response->dtoCollection()->push($vendorResult);
            });

            $response->addInfoMessageResponse('Vendors created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showVendor(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_vendorRepository, 'find'],
            [$id]
        );
    }

    public function updateVendor(UpdateVendorRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $vendor = $this->_vendorRepository->find($request->id);

            if ($vendor) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $vendor->fill([
                    "role_id" => $request->role_id,
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($vendor, $request);

                $rules = [
                    'role_id' => 'required|integer',
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255'
                ];

                $brokenRules = $vendor->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $vendorResult = $unitOfWork->markDirtyAndSaveChange($this->_vendorRepository, $vendor);

                $response->dto = $vendorResult;
                $response->addInfoMessageResponse('Vendor updated');

                return $response;
            }

            $response->addErrorMessageResponse('Vendor not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateVendors(Collection $requests): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $requests->each(function($request, $key) use($response, $unitOfWork) {
                $vendor = $this->_vendorRepository->find($request->id);

                if ($vendor) {
                    $vendor->fill([
                        "role_id" => $request->role_id,
                        "name" => $request->name,
                        "slug" => $request->slug,
                        "description" => $request->description
                    ]);

                    $this->setAuditableInformationFromRequest($vendor, $request);

                    $rules = [
                        'role_id' => 'required|integer',
                        'name' => 'required|string|max:255',
                        'slug' => 'required|string|max:255'
                    ];

                    $brokenRules = $vendor->validate($rules, $request);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }

                    $vendorResult = $unitOfWork->markDirtyAndSaveChange($this->_vendorRepository, $vendor);

                    $response->dtoCollection()->push($vendorResult);
                }
            });

            $response->addInfoMessageResponse('Vendors updated');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyVendor(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $vendor = $this->_vendorRepository->find($id);

            if ($vendor) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $vendorResult = $unitOfWork->markRemoveAndSaveChange($this->_vendorRepository, $vendor);

                $response->result = $vendorResult;

                return $response;
            }

            $response->addErrorMessageResponse('Vendor not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyVendors(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $vendor = $this->_vendorRepository->find($id);

                if ($vendor) {
                    $unitOfWork->markRemove($this->_vendorRepository, $vendor);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Vendors deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugVendor(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(VendorEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getCountries(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_countryRepository, 'allWithChunk']
        );
    }

    public function getCountriesListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_countryRepository, 'listSearch'],
            $request
        );
    }

    public function getCountriesPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_countryRepository, 'pageSearch'],
            $request
        );
    }

    public function createCountry(CreateCountryRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $country = $this->_countryRepository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "calling_code" => $request->calling_code,
                "iso_code_two_digit" => $request->iso_code_two_digit,
                "iso_code_three_digit" => $request->iso_code_three_digit
            ]);

            $this->setAuditableInformationFromRequest($country, $request);

            $rules = [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'calling_code' => 'string|max:255',
                'iso_code_two_digit' => 'string|max:255',
                'iso_code_three_digit' => 'string|max:255'
            ];

            $brokenRules = $country->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $countryResult = $unitOfWork->markNewAndSaveChange($this->_countryRepository, $country);

            $response->dto = $countryResult;
            $response->addInfoMessageResponse('Country created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showCountry(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_countryRepository, 'find'],
            [$id]
        );
    }

    public function updateCountry(UpdateCountryRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $country = $this->_countryRepository->find($request->id);

            if ($country) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $country->fill([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "calling_code" => $request->calling_code,
                    "iso_code_two_digit" => $request->iso_code_two_digit,
                    "iso_code_three_digit" => $request->iso_code_three_digit,
                ]);

                $this->setAuditableInformationFromRequest($country, $request);

                $rules = [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255',
                    'calling_code' => 'string|max:255',
                    'iso_code_two_digit' => 'string|max:255',
                    'iso_code_three_digit' => 'string|max:255',
                ];

                $brokenRules = $country->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $vendorResult = $unitOfWork->markDirtyAndSaveChange($this->_countryRepository, $country);

                $response->dto = $vendorResult;
                $response->addInfoMessageResponse('Country updated');

                return $response;
            }

            $response->addErrorMessageResponse('Country not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyCountry(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $country = $this->_countryRepository->find($id);

            if ($country) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $countryResult = $unitOfWork->markRemoveAndSaveChange($this->_countryRepository, $country);

                $response->result = $countryResult;

                return $response;
            }

            $response->addErrorMessageResponse('Country not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugCountry(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(CountryEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getOrganizations(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_organizationRepository, 'findAllWithChunk']
        );
    }

    public function getOrganizationsListSearch(ListSearchRequest $request, int $countryId = null): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_organizationRepository, 'findOrganizationsListSearch'],
            $request, ['countryId' => $countryId]
        );
    }

    public function getOrganizationsPageSearch(PageSearchRequest $request, int $countryId = null): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_organizationRepository, 'findOrganizationsPageSearch'],
            $request, ['countryId' => $countryId]
        );
    }

    public function createOrganization(CreateOrganizationRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $organization = $this->_organizationRepository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "country_id" => $request->country_id,
                "description" => $request->description
            ]);

            $this->setAuditableInformationFromRequest($organization, $request);

            $rules = [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'country_id' => 'required|int',
                'description' => 'string'
            ];

            $brokenRules = $organization->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $relations = [];

            //--- Vendor (Alias) ---//
            if (isset($request->vendors)) {
                $rules = [
                    'role_id' => 'required|int',
                    'name' => 'required',
                    'slug' => 'required'
                ];

                foreach ($request->vendors as $key => $value) {
                    $request->vendors[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $organization->validate($rules, (object)$request->vendors[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["vendors"] = [
                    "data" => $request->vendors,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- Media ---//
            if (isset($request->media)) {
                $medias = [];

                foreach ($request->media as $media) {
                    $medias[$media['media_id']] = [
                        'attribute' => $media['pivot']['attribute']
                    ];
                }

                $relations['media'] = [
                    'data' => $medias,
                    'method' => RelationMethodType::SYNC()
                ];
            }

            $organizationResult = $unitOfWork->markNewAndSaveChange($this->_organizationRepository, $organization, $relations);

            $response->dto = $organizationResult;
            $response->addInfoMessageResponse('Organization created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showOrganization(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_organizationRepository, 'findOrganizationById'],
            [$id]
        );
    }

    public function updateOrganization(UpdateOrganizationRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $organization = $this->_organizationRepository->find($request->id);

            if ($organization) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $organization->fill([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "country_id" => $request->country_id,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($organization, $request);

                $rules = [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255',
                    'country_id' => 'required|integer|max:255',
                    'description' => 'string'
                ];

                $brokenRules = $organization->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $relations = [];

                //--- Vendor (Alias) ---//
                if (isset($request->vendors)) {
                    $rules = [
                        'role_id' => 'required',
                        'name' => 'required',
                        'slug' => 'required'
                    ];

                    foreach ($request->vendors as $key => $value) {
                        $request->vendors[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $organization->validate($rules, (object)$request->vendors[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["vendors"] = [
                        "data" => $request->vendors,
                        "method" => RelationMethodType::SYNC()
                    ];
                }

                //--- Media ---//
                if (isset($request->media)) {
                    $medias = [];

                    foreach ($request->media as $media) {
                        $medias[$media['media_id']] = [
                            'attribute' => $media['pivot']['attribute']
                        ];
                    }

                    $relations['media'] = [
                        'data' => $medias,
                        'method' => 'sync'
                    ];
                }

                $organizationResult = $unitOfWork->markDirtyAndSaveChange($this->_airportRepository, $organization, $relations);

                $response->dto = $organizationResult;
                $response->addInfoMessageResponse('Organization updated');

                return $response;
            }

            $response->addErrorMessageResponse('Organization not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyOrganization(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $organization = $this->_organizationRepository->findOrganizationById($id);

            if ($organization) {
                $media = $organization->media()->first();

                if ($media) {
                    File::delete($media->path . '/' . $media->generate_name);
                    File::delete($media->path . '/thumb/' . $media->generate_name);
                }

                $unitOfWork = $this->_unitOfWorkFactory->create();

                $organizationResult = $unitOfWork->markRemoveAndSaveChange($this->_organizationRepository, $organization);

                $response->result = $organizationResult;

                return $response;
            }

            $response->addErrorMessageResponse('Organization not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugOrganization(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(OrganizationEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
