<?php
namespace App\Service\Departure;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Request\DatetimeRangeRequest;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Domain\Contracts\Depature\IDepartureMetaRepository;
use App\Domain\Contracts\Depature\IDepartureRepository;
use App\Domain\Contracts\System\IRoleRepository;
use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Service\BaseService;
use App\Service\Contracts\Departure\DateTime;
use App\Service\Contracts\Departure\IDepartureService;
use App\Service\Contracts\Departure\Request\CreateDepartureRequest;
use App\Service\Contracts\Departure\Request\UpdateDepartureRequest;
use Illuminate\Support\Collection;

class DepartureService extends BaseService implements IDepartureService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IDepartureRepository $_departureRepository;
    private IDepartureMetaRepository $_departureMetaRepository;
    private IRoleRepository $_roleRepository;

    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IDepartureRepository $departureRepository,
                                IDepartureMetaRepository $departureMetaRepository,
                                IRoleRepository $roleRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;

        $this->_departureRepository = $departureRepository;
        $this->_departureMetaRepository = $departureMetaRepository;
        $this->_roleRepository = $roleRepository;
    }

    public function showDeparture(int $id, array $columns = ['*']): GenericObjectResponse
    {
        return $this->read(
            [$this->_departureRepository, 'findDeparture'],
            ['id' => $id, 'columns' => $columns]
        );
    }

    public function showDepartureByAodbId(int $aodbId, array $columns = ['*']): GenericObjectResponse
    {
        return $this->read(
            [$this->_departureRepository, 'findDepartureByAodbId'],
            ['aodbId' => $aodbId, 'columns' => $columns]
        );
    }

    public function getDepartures(array $ids = null, array $columns = ['*']): GenericCollectionResponse
    {
        return $this->search(
            [$this->_departureRepository, 'findDepartures'],
            ['ids' => $ids, 'columns' => $columns]
        );
    }

    public function getDeparturesByAodbIds(array $aodbIds = null, array $columns = ['*']): GenericCollectionResponse
    {
        return $this->search(
            [$this->_departureRepository, 'findDeparturesByAodbIds'],
            ['aodbIds' => $aodbIds, 'columns' => $columns]
        );
    }

    public function getDeparturesListSearch(ListSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_departureRepository, 'findDeparturesListSearch'],
            $request,
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]
        );
    }

    public function getDeparturesPageSearch(PageSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_departureRepository, 'findDeparturesPageSearch'],
            $request,
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]
        );
    }

    public function getHistoryDeparturesListSearch(ListSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_departureRepository, 'findHistoryDeparturesListSearch'],
            $request,
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]
        );
    }

    public function getHistoryDeparturesPageSearch(PageSearchRequest $request, string $filterBy = null, DatetimeRangeRequest $dateTimeRange = null): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_departureRepository, 'findHistoryDeparturesPageSearch'],
            $request,
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]
        );
    }

    public function getDepartureTobtsUpdated(DatetimeRangeRequest $dateTimeRange = null): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        $departures = $this->search(
            [$this->_departureRepository, 'findDepartureTobtsUpdated'],
            ['dateTimeRange' => $dateTimeRange]
        );

        $groupDepartures = $departures->dtoCollection()->groupBy('id');
        $groupDepartureCollection = new Collection();

        foreach ($groupDepartures as $groupDeparture) {
            if ($groupDeparture->count() > 1) {
                $tobt_init = '-';
                $departureCollections = new Collection();

                foreach ($groupDeparture as $departure) {
                    $departure->tobt_init = $tobt_init;
                    $departureCollections->push($departure);

                    $tobt_init = $departure->tobt_updated;
                }

                $departureCollections->shift();

                foreach ($departureCollections as $departureCollection) {
                    $groupDepartureCollection->push($departureCollection);
                }
            }
        }

        $result['departure_tobts_updated'] = $groupDepartureCollection;

        $roles = $this->search(
            [$this->_roleRepository, 'findRoles'],
            ['groupId' => 1]
        );

        foreach ($roles->dtoCollection() as $role) {
            $result['depature_has_updated_by_' . str_replace(' ', '_', strtolower($role->name)) . '_count'] = $groupDepartureCollection->where('tobt_role_id', '=', $role->id)->count();
        }

        $response->dto = (object) $result;

        return $response;
    }

    public function createDeparture(CreateDepartureRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $departure = $this->_departureRepository->newInstance([
                "aodb_id" => $request->aodb_id,
                "airport_id" => $request->airport_id,
                "flight_number" => $request->flight_number,
                "flight_numberable_id" => $request->flight_numberable_id,
                "flight_numberable_type" => $request->flight_numberable_type,
                "call_sign" => $request->call_sign,
                "nature" => $request->nature,
                "natureable_id" => $request->natureable_id,
                "natureable_type" => $request->natureable_type,
                "acft" => $request->acft,
                "acftable_id" => $request->acftable_id,
                "acftable_type" => $request->acftable_type,
                "register" => $request->register,
                "registerable_id" => $request->registerable_id,
                "registerable_type" => $request->registerable_type,
                "stand" => $request->stand,
                "standable_id" => $request->standable_id,
                "standable_type" => $request->standable_type,
                "gate_name" => $request->gate_name,
                "gate_nameable_id" => $request->gate_nameable_id,
                "gate_nameable_type" => $request->gate_nameable_type,
                "gate_open" => $request->gate_open,
                "gate_openable_id" => $request->gate_openable_id,
                "gate_openable_type" => $request->gate_openable_type,
                "runway_actual" => $request->runway_actual,
                "runway_actualable_id" => $request->runway_actualable_id,
                "runway_actualable_type" => $request->runway_actualable_type,
                "runway_estimated" => $request->runway_estimated,
                "runway_estimatedable_id" => $request->runway_estimatedable_id,
                "runway_estimatedable_type" => $request->runway_estimatedable_type,
                "transit" => $request->transit,
                "transitable_id" => $request->transitable_id,
                "transitable_type" => $request->transitable_type,
                "destination" => $request->destination,
                "destinationable_id" => $request->destinationable_id,
                "destinationable_type" => $request->destinationable_type,
                "status" => $request->status,
                "code_share" => $request->code_share,
                "data_origin" => $request->data_origin,
                "data_originable_id" => $request->data_originable_id,
                "data_originable_type" => $request->data_originable_type
            ]);

            $this->setAuditableInformationFromRequest($departure, $request);

            $rules = [
                'aodb_id' => 'required'
            ];

            $brokenRules = $departure->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $relations = [];

            //--- ACGT ---//
            if (isset($request->acgts)) {
                $rules = [
                    'acgt' => 'required'
                ];

                foreach ($request->acgts as $key => $value) {
                    $request->acgts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->acgts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["acgts"] = [
                    "data" => $request->acgts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ACZT ---//
            if (isset($request->aczts)) {
                $rules = [
                    'aczt' => 'required'
                ];

                foreach ($request->aczts as $key => $value) {
                    $request->aczts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->aczts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["aczts"] = [
                    "data" => $request->aczts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ADIT ---//
            if (isset($request->adits)) {
                $rules = [
                    'adit' => 'required'
                ];

                foreach ($request->adits as $key => $value) {
                    $request->adits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->adits[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["adits"] = [
                    "data" => $request->adits,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- AEGT ---//
            if (isset($request->aegts)) {
                $rules = [
                    'aegt' => 'required'
                ];

                foreach ($request->aegts as $key => $value) {
                    $request->adits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->adits[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["aegts"] = [
                    "data" => $request->aegts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- AEZT ---//
            if (isset($request->aezts)) {
                $rules = [
                    'aezt' => 'required'
                ];

                foreach ($request->aezts as $key => $value) {
                    $request->adits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->adits[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["aezts"] = [
                    "data" => $request->aezts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- AGHT ---//
            if (isset($request->aghts)) {
                $rules = [
                    'aght' => 'required'
                ];

                foreach ($request->aezts as $key => $value) {
                    $request->aghts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->aghts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["aghts"] = [
                    "data" => $request->aghts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- AOBT ---//
            if (isset($request->aobts)) {
                $rules = [
                    'aobt' => 'required'
                ];

                foreach ($request->aobts as $key => $value) {
                    $request->aobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->aobts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["aobts"] = [
                    "data" => $request->aobts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ARDT ---//
            if (isset($request->ardts)) {
                $rules = [
                    'ardt' => 'required'
                ];

                foreach ($request->ardts as $key => $value) {
                    $request->ardts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->ardts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["ardts"] = [
                    "data" => $request->ardts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ARZT ---//
            if (isset($request->arzts)) {
                $rules = [
                    'arzt' => 'required'
                ];

                foreach ($request->arzts as $key => $value) {
                    $request->arzts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->arzts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["arzts"] = [
                    "data" => $request->arzts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- AZAT ---//
            if (isset($request->azats)) {
                $rules = [
                    'azat' => 'required'
                ];

                foreach ($request->arzts as $key => $value) {
                    $request->azats[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->azats[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["azats"] = [
                    "data" => $request->azats,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ASBT ---//
            if (isset($request->asbts)) {
                $rules = [
                    'asbt' => 'required'
                ];

                foreach ($request->asbts as $key => $value) {
                    $request->asbts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->asbts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["asbts"] = [
                    "data" => $request->asbts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ASRT ---//
            if (isset($request->asrts)) {
                $rules = [
                    'asrt' => 'required'
                ];

                foreach ($request->asrts as $key => $value) {
                    $request->asrts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->asrts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["asrts"] = [
                    "data" => $request->asrts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ATETS ---//
            if (isset($request->atets)) {
                $rules = [
                    'atet' => 'required'
                ];

                foreach ($request->atets as $key => $value) {
                    $request->atets[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->atets[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["atets"] = [
                    "data" => $request->atets,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ATST ---//
            if (isset($request->atsts)) {
                $rules = [
                    'atst' => 'required'
                ];

                foreach ($request->atsts as $key => $value) {
                    $request->atsts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->atsts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["atsts"] = [
                    "data" => $request->atsts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ATOT ---//
            if (isset($request->atots)) {
                $rules = [
                    'atst' => 'required'
                ];

                foreach ($request->atots as $key => $value) {
                    $request->atots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->atots[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["atots"] = [
                    "data" => $request->atots,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ATTT ---//
            if (isset($request->attts)) {
                $rules = [
                    'attt' => 'required'
                ];

                foreach ($request->attts as $key => $value) {
                    $request->attts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->attts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["attts"] = [
                    "data" => $request->attts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- AXOT ---//
            if (isset($request->axots)) {
                $rules = [
                    'axot' => 'required'
                ];

                foreach ($request->axots as $key => $value) {
                    $request->axots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->axots[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["axots"] = [
                    "data" => $request->axots,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- CTOT ---//
            if (isset($request->ctots)) {
                $rules = [
                    'ctot' => 'required'
                ];

                foreach ($request->ctots as $key => $value) {
                    $request->ctots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->ctots[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["ctots"] = [
                    "data" => $request->ctots,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ECZT ---//
            if (isset($request->eczts)) {
                $rules = [
                    'eczt' => 'required'
                ];

                foreach ($request->eczts as $key => $value) {
                    $request->eczts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->eczts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["eczts"] = [
                    "data" => $request->eczts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- EDIT ---//
            if (isset($request->edits)) {
                $rules = [
                    'edit' => 'required'
                ];

                foreach ($request->edits as $key => $value) {
                    $request->edits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->edits[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["edits"] = [
                    "data" => $request->edits,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- EEZT ---//
            if (isset($request->eezts)) {
                $rules = [
                    'eezt' => 'required'
                ];

                foreach ($request->eezts as $key => $value) {
                    $request->eezts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->eezts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["eezts"] = [
                    "data" => $request->eezts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- EOBT ---//
            if (isset($request->eobts)) {
                $rules = [
                    'eobt' => 'required'
                ];

                foreach ($request->eobts as $key => $value) {
                    $request->eobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->eobts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["eobts"] = [
                    "data" => $request->eobts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ERZT ---//
            if (isset($request->erzts)) {
                $rules = [
                    'erzt' => 'required'
                ];

                foreach ($request->erzts as $key => $value) {
                    $request->erzts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->erzts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["erzts"] = [
                    "data" => $request->erzts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- ETOT ---//
            if (isset($request->etots)) {
                $rules = [
                    'etot' => 'required'
                ];

                foreach ($request->etots as $key => $value) {
                    $request->etots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->etots[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["etots"] = [
                    "data" => $request->etots,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- EXOT ---//
            if (isset($request->exots)) {
                $rules = [
                    'exot' => 'required'
                ];

                foreach ($request->exots as $key => $value) {
                    $request->exots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->exots[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["exots"] = [
                    "data" => $request->exots,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- SOBT ---//
            if (isset($request->sobts)) {
                $rules = [
                    'sobt' => 'required'
                ];

                foreach ($request->sobts as $key => $value) {
                    $request->sobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->sobts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["sobts"] = [
                    "data" => $request->sobts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- STET ---//
            if (isset($request->stets)) {
                $rules = [
                    'stet' => 'required'
                ];

                foreach ($request->stets as $key => $value) {
                    $request->stets[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->stets[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["stets"] = [
                    "data" => $request->stets,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- STST ---//
            if (isset($request->ststs)) {
                $rules = [
                    'stst' => 'required'
                ];

                foreach ($request->ststs as $key => $value) {
                    $request->ststs[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->ststs[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["ststs"] = [
                    "data" => $request->ststs,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- TOBT ---//
            if (isset($request->tobts)) {
                $rules = [
                    'tobt' => 'required'
                ];

                foreach ($request->tobts as $key => $value) {
                    $request->tobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->tobts[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["tobts"] = [
                    "data" => $request->tobts,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- TSAT ---//
            if (isset($request->tsats)) {
                $rules = [
                    'tsat' => 'required'
                ];

                foreach ($request->tsats as $key => $value) {
                    $request->tsats[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->tsats[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["tsats"] = [
                    "data" => $request->tsats,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- TTOT ---//
            if (isset($request->ttots)) {
                $rules = [
                    'ttot' => 'required'
                ];

                foreach ($request->ttots as $key => $value) {
                    $request->ttots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                    $brokenRules = $departure->validate($rules, (object)$request->ttots[$key]);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }
                }

                $relations["ttots"] = [
                    "data" => $request->ttots,
                    "method" => RelationMethodType::CREATE_MANY()
                ];
            }

            //--- Departure Meta ---//
            $departureMeta = $this->_departureMetaRepository->newInstance((array)$request->departure_meta);

            $this->setAuditableInformationFromRequest($departureMeta, $request);

            $rules = [
                'flight' => 'required',
                'sobt' => 'required',
                'eobt' => 'required',
                'tobt' => 'required',
                'aegt' => 'required',
                'ardt' => 'required',
                'aobt' => 'required',
                'tsat' => 'required',
                'ttot' => 'required',
                'atot' => 'required',
            ];

            $brokenRules = $departureMeta->validate($rules, $request->departure_meta);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $relations["departureMeta"] = [
                "data" => $departureMeta,
                "method" => RelationMethodType::SAVE()
            ];

            $departureResult = $unitOfWork->markNewAndSaveChange($this->_departureRepository, $departure, $relations);

            $departure = $this->showDeparture($departureResult->id);

            $response->dto = $departure->dto;
            $response->addInfoMessageResponse('Departure created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function createDepartures(Collection $requests): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $requests->each(function($request, $key) use($response, $unitOfWork) {
                $departure = $this->_departureRepository->newInstance([
                    "aodb_id" => $request->aodb_id,
                    "airport_id" => $request->airport_id,
                    "flight_number" => $request->flight_number,
                    "flight_numberable_id" => $request->flight_numberable_id,
                    "flight_numberable_type" => $request->flight_numberable_type,
                    "call_sign" => $request->call_sign,
                    "nature" => $request->nature,
                    "natureable_id" => $request->natureable_id,
                    "natureable_type" => $request->natureable_type,
                    "acft" => $request->acft,
                    "acftable_id" => $request->acftable_id,
                    "acftable_type" => $request->acftable_type,
                    "register" => $request->register,
                    "registerable_id" => $request->registerable_id,
                    "registerable_type" => $request->registerable_type,
                    "stand" => $request->stand,
                    "standable_id" => $request->standable_id,
                    "standable_type" => $request->standable_type,
                    "gate_name" => $request->gate_name,
                    "gate_nameable_id" => $request->gate_nameable_id,
                    "gate_nameable_type" => $request->gate_nameable_type,
                    "gate_open" => $request->gate_open,
                    "gate_openable_id" => $request->gate_openable_id,
                    "gate_openable_type" => $request->gate_openable_type,
                    "runway_actual" => $request->runway_actual,
                    "runway_actualable_id" => $request->runway_actualable_id,
                    "runway_actualable_type" => $request->runway_actualable_type,
                    "runway_estimated" => $request->runway_estimated,
                    "runway_estimatedable_id" => $request->runway_estimatedable_id,
                    "runway_estimatedable_type" => $request->runway_estimatedable_type,
                    "transit" => $request->transit,
                    "transitable_id" => $request->transitable_id,
                    "transitable_type" => $request->transitable_type,
                    "destination" => $request->destination,
                    "destinationable_id" => $request->destinationable_id,
                    "destinationable_type" => $request->destinationable_type,
                    "status" => $request->status,
                    "code_share" => $request->code_share,
                    "data_origin" => $request->data_origin,
                    "data_originable_id" => $request->data_originable_id,
                    "data_originable_type" => $request->data_originable_type
                ]);

                $this->setAuditableInformationFromRequest($departure, $request);

                $rules = [
                    'aodb_id' => 'required'
                ];

                $brokenRules = $departure->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                        foreach ($_value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $relations = [];

                //--- ACGT ---//
                if ($request->acgts) {
                    $rules = [
                        'acgt' => 'required'
                    ];

                    foreach ($request->acgts as $_key => $_value) {
                        $request->acgts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->acgts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["acgts"] = [
                        "data" => $request->acgts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ACZT ---//
                if ($request->aczts) {
                    $rules = [
                        'aczt' => 'required'
                    ];

                    foreach ($request->aczts as $_key => $_value) {
                        $request->aczts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->aczts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aczts"] = [
                        "data" => $request->aczts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ADIT ---//
                if ($request->adits) {
                    $rules = [
                        'adit' => 'required'
                    ];

                    foreach ($request->adits as $_key => $_value) {
                        $request->adits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->adits[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["adits"] = [
                        "data" => $request->adits,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- AEGT ---//
                if ($request->aegts) {
                    $rules = [
                        'aegt' => 'required'
                    ];

                    foreach ($request->aegts as $_key => $_value) {
                        $request->adits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->adits[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aegts"] = [
                        "data" => $request->aegts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- AEZT ---//
                if ($request->aezts) {
                    $rules = [
                        'aezt' => 'required'
                    ];

                    foreach ($request->aezts as $_key => $_value) {
                        $request->adits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->adits[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aezts"] = [
                        "data" => $request->aezts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- AGHT ---//
                if ($request->aghts) {
                    $rules = [
                        'aght' => 'required'
                    ];

                    foreach ($request->aezts as $_key => $_value) {
                        $request->aghts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->aghts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aghts"] = [
                        "data" => $request->aghts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- AOBT ---//
                if ($request->aobts) {
                    $rules = [
                        'aobt' => 'required'
                    ];

                    foreach ($request->aobts as $_key => $_value) {
                        $request->aobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->aobts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aobts"] = [
                        "data" => $request->aobts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ARDT ---//
                if ($request->ardts) {
                    $rules = [
                        'ardt' => 'required'
                    ];

                    foreach ($request->ardts as $_key => $_value) {
                        $request->ardts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ardts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ardts"] = [
                        "data" => $request->ardts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ARZT ---//
                if ($request->arzts) {
                    $rules = [
                        'arzt' => 'required'
                    ];

                    foreach ($request->arzts as $_key => $_value) {
                        $request->arzts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->arzts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["arzts"] = [
                        "data" => $request->arzts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- AZAT ---//
                if ($request->azats) {
                    $rules = [
                        'azat' => 'required'
                    ];

                    foreach ($request->arzts as $_key => $_value) {
                        $request->azats[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->azats[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["azats"] = [
                        "data" => $request->azats,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ASBT ---//
                if ($request->asbts) {
                    $rules = [
                        'asbt' => 'required'
                    ];

                    foreach ($request->asbts as $_key => $_value) {
                        $request->asbts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->asbts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["asbts"] = [
                        "data" => $request->asbts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ASRT ---//
                if ($request->asrts) {
                    $rules = [
                        'asrt' => 'required'
                    ];

                    foreach ($request->asrts as $_key => $_value) {
                        $request->asrts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->asrts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["asrts"] = [
                        "data" => $request->asrts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ATETS ---//
                if ($request->atets) {
                    $rules = [
                        'atet' => 'required'
                    ];

                    foreach ($request->atets as $_key => $_value) {
                        $request->atets[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->atets[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["atets"] = [
                        "data" => $request->atets,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ATST ---//
                if ($request->atsts) {
                    $rules = [
                        'atst' => 'required'
                    ];

                    foreach ($request->atsts as $_key => $_value) {
                        $request->atsts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->atsts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["atsts"] = [
                        "data" => $request->atsts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ATOT ---//
                if ($request->atots) {
                    $rules = [
                        'atot' => 'required'
                    ];

                    foreach ($request->atots as $_key => $_value) {
                        $request->atots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->atots[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["atots"] = [
                        "data" => $request->atots,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ATTT ---//
                if ($request->attts) {
                    $rules = [
                        'attt' => 'required'
                    ];

                    foreach ($request->attts as $_key => $_value) {
                        $request->attts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->attts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["attts"] = [
                        "data" => $request->attts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- AXOT ---//
                if ($request->axots) {
                    $rules = [
                        'axot' => 'required'
                    ];

                    foreach ($request->axots as $_key => $_value) {
                        $request->axots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->axots[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["axots"] = [
                        "data" => $request->axots,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- CTOT ---//
                if ($request->ctots) {
                    $rules = [
                        'ctot' => 'required'
                    ];

                    foreach ($request->ctots as $_key => $_value) {
                        $request->ctots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ctots[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ctots"] = [
                        "data" => $request->ctots,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ECZT ---//
                if ($request->eczts) {
                    $rules = [
                        'eczt' => 'required'
                    ];

                    foreach ($request->eczts as $_key => $_value) {
                        $request->eczts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->eczts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["eczts"] = [
                        "data" => $request->eczts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- EDIT ---//
                if ($request->edits) {
                    $rules = [
                        'edit' => 'required'
                    ];

                    foreach ($request->edits as $_key => $_value) {
                        $request->edits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->edits[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["edits"] = [
                        "data" => $request->edits,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- EEZT ---//
                if ($request->eezts) {
                    $rules = [
                        'eezt' => 'required'
                    ];

                    foreach ($request->eezts as $_key => $_value) {
                        $request->eezts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->eezts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["eezts"] = [
                        "data" => $request->eezts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- EOBT ---//
                if ($request->eobts) {
                    $rules = [
                        'eobt' => 'required'
                    ];

                    foreach ($request->eobts as $_key => $_value) {
                        $request->eobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->eobts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["eobts"] = [
                        "data" => $request->eobts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ERZT ---//
                if ($request->erzts) {
                    $rules = [
                        'erzt' => 'required'
                    ];

                    foreach ($request->erzts as $_key => $_value) {
                        $request->erzts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->erzts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["erzts"] = [
                        "data" => $request->erzts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- ETOT ---//
                if ($request->etots) {
                    $rules = [
                        'etot' => 'required'
                    ];

                    foreach ($request->etots as $_key => $_value) {
                        $request->etots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->etots[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["etots"] = [
                        "data" => $request->etots,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- EXOT ---//
                if ($request->exots) {
                    $rules = [
                        'exot' => 'required'
                    ];

                    foreach ($request->exots as $_key => $_value) {
                        $request->exots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->exots[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["exots"] = [
                        "data" => $request->exots,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- SOBT ---//
                if ($request->sobts) {
                    $rules = [
                        'sobt' => 'required'
                    ];

                    foreach ($request->sobts as $_key => $_value) {
                        $request->sobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->sobts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["sobts"] = [
                        "data" => $request->sobts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- STET ---//
                if ($request->stets) {
                    $rules = [
                        'stet' => 'required'
                    ];

                    foreach ($request->stets as $_key => $_value) {
                        $request->stets[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->stets[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["stets"] = [
                        "data" => $request->stets,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- STST ---//
                if ($request->ststs) {
                    $rules = [
                        'stst' => 'required'
                    ];

                    foreach ($request->ststs as $_key => $_value) {
                        $request->ststs[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ststs[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ststs"] = [
                        "data" => $request->ststs,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- TOBT ---//
                if ($request->tobts) {
                    $rules = [
                        'tobt' => 'required'
                    ];

                    foreach ($request->tobts as $_key => $_value) {
                        $request->tobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->tobts[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["tobts"] = [
                        "data" => $request->tobts,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- TSAT ---//
                if ($request->tsats) {
                    $rules = [
                        'tsat' => 'required'
                    ];

                    foreach ($request->tsats as $_key => $_value) {
                        $request->tsats[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->tsats[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["tsats"] = [
                        "data" => $request->tsats,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- TTOT ---//
                if ($request->ttots) {
                    $rules = [
                        'ttot' => 'required'
                    ];

                    foreach ($request->ttots as $_key => $_value) {
                        $request->ttots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ttots[$_key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                foreach ($__value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ttots"] = [
                        "data" => $request->ttots,
                        "method" => RelationMethodType::CREATE_MANY()
                    ];
                }

                //--- Departure Meta ---//
                $departureMeta = $this->_departureMetaRepository->newInstance((array)$request->departure_meta);

                $this->setAuditableInformationFromRequest($departureMeta, $request);

                $rules = [
                    'flight' => 'required',
                    'sobt' => 'required',
                    'eobt' => 'required',
                    'tobt' => 'required',
                    'aegt' => 'required',
                    'ardt' => 'required',
                    'aobt' => 'required',
                    'tsat' => 'required',
                    'ttot' => 'required',
                    'atot' => 'required',
                ];

                $brokenRules = $departureMeta->validate($rules, (object)$request->departure_meta);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                        foreach ($_value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $relations["departureMeta"] = [
                    "data" => $departureMeta,
                    "method" => RelationMethodType::SAVE()
                ];

                $departureResult = $unitOfWork->markNewAndSaveChange($this->_departureRepository, $departure, $relations);

                $departure = $this->showDeparture($departureResult->id);

                $response->dtoCollection()->push($departure->dto->toArray());
            });

            $response->addInfoMessageResponse('Departures created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateDeparture(UpdateDepartureRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $departure = ($request->aodb_id <> 0) ? $this->_departureRepository->findWhere(['aodb_id', '=', $request->aodb_id])
                ->first() : $this->_departureRepository->find($request->id);

            if ($departure) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $departure->fill([
                    "airport_id" => $request->airport_id,
                    "flight_number" => $request->flight_number,
                    "flight_numberable_id" => $request->flight_numberable_id,
                    "flight_numberable_type" => $request->flight_numberable_type,
                    "call_sign" => $request->call_sign,
                    "nature" => $request->nature,
                    "natureable_id" => $request->natureable_id,
                    "natureable_type" => $request->natureable_type,
                    "acft" => $request->acft,
                    "acftable_id" => $request->acftable_id,
                    "acftable_type" => $request->acftable_type,
                    "register" => $request->register,
                    "registerable_id" => $request->registerable_id,
                    "registerable_type" => $request->registerable_type,
                    "stand" => $request->stand,
                    "standable_id" => $request->standable_id,
                    "standable_type" => $request->standable_type,
                    "gate_name" => $request->gate_name,
                    "gate_nameable_id" => $request->gate_nameable_id,
                    "gate_nameable_type" => $request->gate_nameable_type,
                    "gate_open" => $request->gate_open,
                    "gate_openable_id" => $request->gate_openable_id,
                    "gate_openable_type" => $request->gate_openable_type,
                    "runway_actual" => $request->runway_actual,
                    "runway_actualable_id" => $request->runway_actualable_id,
                    "runway_actualable_type" => $request->runway_actualable_type,
                    "runway_estimated" => $request->runway_estimated,
                    "runway_estimatedable_id" => $request->runway_estimatedable_id,
                    "transit" => $request->transit,
                    "transitable_id" => $request->transitable_id,
                    "transitable_type" => $request->transitable_type,
                    "destination" => $request->destination,
                    "destinationable_id" => $request->destinationable_id,
                    "destinationable_type" => $request->destinationable_type,
                    "status" => $request->status,
                    "code_share" => $request->code_share,
                    "data_origin" => $request->data_origin,
                    "data_originable_id" => $request->data_originable_id,
                    "data_originable_type" => $request->data_originable_type
                ]);

                $this->setAuditableInformationFromRequest($departure, $request);

                $rules = [
                ];

                $brokenRules = $departure->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $relations = [];

                //--- ACGT ---//
                if (isset($request->acgts)) {
                    $rules = [
                        'acgt' => 'required'
                    ];

                    foreach ($request->acgts as $key => $value) {
                        $request->acgts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->acgts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["acgts"] = [
                        "data" => $request->acgts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ACZT ---//
                if (isset($request->aczts)) {
                    $rules = [
                        'aczt' => 'required'
                    ];

                    foreach ($request->aczts as $key => $value) {
                        $request->aczts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->aczts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aczts"] = [
                        "data" => $request->aczts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ADIT ---//
                if (isset($request->adits)) {
                    $rules = [
                        'adit' => 'required'
                    ];

                    foreach ($request->adits as $key => $value) {
                        $request->adits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->adits[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["adits"] = [
                        "data" => $request->adits,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- AEGT ---//
                if (isset($request->aegts)) {
                    $rules = [
                        'aegt' => 'required'
                    ];

                    foreach ($request->aegts as $key => $value) {
                        $request->adits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->adits[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aegts"] = [
                        "data" => $request->aegts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- AEZT ---//
                if (isset($request->aezts)) {
                    $rules = [
                        'aezt' => 'required'
                    ];

                    foreach ($request->aezts as $key => $value) {
                        $request->adits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->adits[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aezts"] = [
                        "data" => $request->aezts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- AGHT ---//
                if (isset($request->aghts)) {
                    $rules = [
                        'aght' => 'required'
                    ];

                    foreach ($request->aezts as $key => $value) {
                        $request->aghts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->aghts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aghts"] = [
                        "data" => $request->aghts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- AOBT ---//
                if (isset($request->aobts)) {
                    $rules = [
                        'aobt' => 'required'
                    ];

                    foreach ($request->aobts as $key => $value) {
                        $request->aobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->aobts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["aobts"] = [
                        "data" => $request->aobts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ARDT ---//
                if (isset($request->ardts)) {
                    $rules = [
                        'ardt' => 'required'
                    ];

                    foreach ($request->ardts as $key => $value) {
                        $request->ardts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ardts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ardts"] = [
                        "data" => $request->ardts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ARZT ---//
                if (isset($request->arzts)) {
                    $rules = [
                        'arzt' => 'required'
                    ];

                    foreach ($request->arzts as $key => $value) {
                        $request->ardts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ardts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["arzts"] = [
                        "data" => $request->arzts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- AZAT ---//
                if (isset($request->azats)) {
                    $rules = [
                        'azat' => 'required'
                    ];

                    foreach ($request->arzts as $key => $value) {
                        $request->azats[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->azats[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["azats"] = [
                        "data" => $request->azats,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ASBT ---//
                if (isset($request->asbts)) {
                    $rules = [
                        'asbt' => 'required'
                    ];

                    foreach ($request->asbts as $key => $value) {
                        $request->asbts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->asbts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["asbts"] = [
                        "data" => $request->asbts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ASRT ---//
                if (isset($request->asrts)) {
                    $rules = [
                        'asrt' => 'required'
                    ];

                    foreach ($request->asrts as $key => $value) {
                        $request->asrts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->asrts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["asrts"] = [
                        "data" => $request->asrts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ATETS ---//
                if (isset($request->atets)) {
                    $rules = [
                        'atet' => 'required'
                    ];

                    foreach ($request->atets as $key => $value) {
                        $request->atets[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->atets[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["atets"] = [
                        "data" => $request->atets,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ATST ---//
                if (isset($request->atsts)) {
                    $rules = [
                        'atst' => 'required'
                    ];

                    foreach ($request->atsts as $key => $value) {
                        $request->atsts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->atsts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }


                    $relations["atsts"] = [
                        "data" => $request->atsts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ATOT ---//
                if (isset($request->atots)) {
                    $rules = [
                        'atst' => 'required'
                    ];

                    foreach ($request->atots as $key => $value) {
                        $request->atots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->atots[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["atots"] = [
                        "data" => $request->atots,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ATTT ---//
                if (isset($request->attts)) {
                    $rules = [
                        'attt' => 'required'
                    ];

                    foreach ($request->attts as $key => $value) {
                        $request->attts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->attts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["attts"] = [
                        "data" => $request->attts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- AXOT ---//
                if (isset($request->axots)) {
                    $rules = [
                        'axot' => 'required'
                    ];

                    foreach ($request->axots as $key => $value) {
                        $request->axots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->axots[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["axots"] = [
                        "data" => $request->axots,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- CTOT ---//
                if (isset($request->ctots)) {
                    $rules = [
                        'ctot' => 'required'
                    ];

                    foreach ($request->ctots as $key => $value) {
                        $request->ctots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ctots[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ctots"] = [
                        "data" => $request->ctots,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ECZT ---//
                if (isset($request->eczts)) {
                    $rules = [
                        'eczt' => 'required'
                    ];

                    foreach ($request->eczts as $key => $value) {
                        $request->eczts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->eczts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["eczts"] = [
                        "data" => $request->eczts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- EDIT ---//
                if (isset($request->edits)) {
                    $rules = [
                        'edit' => 'required'
                    ];

                    foreach ($request->edits as $key => $value) {
                        $request->edits[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->edits[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["edits"] = [
                        "data" => $request->edits,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- EEZT ---//
                if (isset($request->eezts)) {
                    $rules = [
                        'eezt' => 'required'
                    ];

                    foreach ($request->eezts as $key => $value) {
                        $request->eezts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->eezts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["eezts"] = [
                        "data" => $request->eezts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- EOBT ---//
                if (isset($request->eobts)) {
                    $rules = [
                        'eobt' => 'required'
                    ];

                    foreach ($request->eobts as $key => $value) {
                        $request->eobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->eobts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["eobts"] = [
                        "data" => $request->eobts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ERZT ---//
                if (isset($request->erzts)) {
                    $rules = [
                        'erzt' => 'required'
                    ];

                    foreach ($request->erzts as $key => $value) {
                        $request->erzts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->erzts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["erzts"] = [
                        "data" => $request->erzts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- ETOT ---//
                if (isset($request->etots)) {
                    $rules = [
                        'etot' => 'required'
                    ];

                    foreach ($request->etots as $key => $value) {
                        $request->etots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->etots[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["etots"] = [
                        "data" => $request->etots,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- EXOT ---//
                if (isset($request->exots)) {
                    $rules = [
                        'exot' => 'required'
                    ];

                    foreach ($request->exots as $key => $value) {
                        $request->exots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->exots[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["exots"] = [
                        "data" => $request->exots,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- SOBT ---//
                if (isset($request->sobts)) {
                    $rules = [
                        'sobt' => 'required'
                    ];

                    foreach ($request->sobts as $key => $value) {
                        $request->sobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->sobts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["sobts"] = [
                        "data" => $request->sobts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- STET ---//
                if (isset($request->stets)) {
                    $rules = [
                        'stet' => 'required'
                    ];

                    foreach ($request->stets as $key => $value) {
                        $request->stets[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->stets[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["stets"] = [
                        "data" => $request->stets,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- STST ---//
                if (isset($request->ststs)) {
                    $rules = [
                        'stst' => 'required'
                    ];

                    foreach ($request->ststs as $key => $value) {
                        $request->ststs[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ststs[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ststs"] = [
                        "data" => $request->ststs,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- TOBT ---//
                if (isset($request->tobts)) {
                    $rules = [
                        'tobt' => 'required'
                    ];

                    foreach ($request->tobts as $key => $value) {
                        $request->tobts[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->tobts[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["tobts"] = [
                        "data" => $request->tobts,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- TSAT ---//
                if (isset($request->tsats)) {
                    $rules = [
                        'tsat' => 'required'
                    ];

                    foreach ($request->tsats as $key => $value) {
                        $request->tsats[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->tsats[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["tsats"] = [
                        "data" => $request->tsats,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- TTOT ---//
                if (isset($request->ttots)) {
                    $rules = [
                        'ttot' => 'required'
                    ];

                    foreach ($request->ttots as $key => $value) {
                        $request->ttots[$key] = $this->setAuditableInformationFromRequest($value, $request);

                        $brokenRules = $departure->validate($rules, (object)$request->ttots[$key]);

                        if ($brokenRules->fails()) {
                            foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                                foreach ($_value as $message) {
                                    $response->addErrorMessageResponse($message);
                                }
                            }

                            return $response;
                        }
                    }

                    $relations["ttots"] = [
                        "data" => $request->ttots,
                        "method" => RelationMethodType::CREATE_MANY(),
                        "detach" => false
                    ];
                }

                //--- Departure Meta ---//
                if (isset($request->departure_meta)) {
                    $request->departure_meta->id = $departure->departureMeta->id ?? 0;
                    $departureMeta = $this->setAuditableInformationFromRequest((array)$request->departure_meta, $request);

                    $relations["departureMeta"] = [
                        "data" => $departureMeta,
                        "method" => RelationMethodType::PUSH()
                    ];
                }

                $departureResult = $unitOfWork->markDirtyAndSaveChange($this->_departureRepository, $departure, $relations);

                $departure = $this->showDeparture($departureResult->id);

                $response->dto = $departure->dto;
                $response->addInfoMessageResponse('Departure updated');

                return $response;
            }

            $response->addErrorMessageResponse('Departure not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateDepartures(Collection $requests): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $requests->each(function($request, $key) use($response, $unitOfWork) {
                $departure = ($request->aodb_id <> 0) ? $this->_departureRepository->findWhere([['aodb_id', '=', $request->aodb_id]])
                    ->first() : $this->_departureRepository->find($request->id);

                if ($departure) {
                    $departure->fill([
                        "airport_id" => $request->airport_id,
                        "flight_number" => $request->flight_number,
                        "flight_numberable_id" => $request->flight_numberable_id,
                        "flight_numberable_type" => $request->flight_numberable_type,
                        "call_sign" => $request->call_sign,
                        "nature" => $request->nature,
                        "natureable_id" => $request->natureable_id,
                        "natureable_type" => $request->natureable_type,
                        "acft" => $request->acft,
                        "acftable_id" => $request->acftable_id,
                        "acftable_type" => $request->acftable_type,
                        "register" => $request->register,
                        "registerable_id" => $request->registerable_id,
                        "registerable_type" => $request->registerable_type,
                        "stand" => $request->stand,
                        "standable_id" => $request->standable_id,
                        "standable_type" => $request->standable_type,
                        "gate_name" => $request->gate_name,
                        "gate_nameable_id" => $request->gate_nameable_id,
                        "gate_nameable_type" => $request->gate_nameable_type,
                        "gate_open" => $request->gate_open,
                        "gate_openable_id" => $request->gate_openable_id,
                        "gate_openable_type" => $request->gate_openable_type,
                        "runway_actual" => $request->runway_actual,
                        "runway_actualable_id" => $request->runway_actualable_id,
                        "runway_actualable_type" => $request->runway_actualable_type,
                        "runway_estimated" => $request->runway_estimated,
                        "runway_estimatedable_id" => $request->runway_estimatedable_id,
                        "transit" => $request->transit,
                        "transitable_id" => $request->transitable_id,
                        "transitable_type" => $request->transitable_type,
                        "destination" => $request->destination,
                        "destinationable_id" => $request->destinationable_id,
                        "destinationable_type" => $request->destinationable_type,
                        "status" => $request->status,
                        "code_share" => $request->code_share,
                        "data_origin" => $request->data_origin,
                        "data_originable_id" => $request->data_originable_id,
                        "data_originable_type" => $request->data_originable_type
                    ]);

                    $this->setAuditableInformationFromRequest($departure, $request);

                    $rules = [];

                    $brokenRules = $departure->validate($rules, $request);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $_key => $_value) {
                            foreach ($_value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }

                    $relations = [];

                    //--- ACGT ---//
                    if ($request->acgts) {
                        $rules = [
                            'acgt' => 'required'
                        ];

                        foreach ($request->acgts as $_key => $_value) {
                            $request->acgts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->acgts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["acgts"] = [
                            "data" => $request->acgts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ACZT ---//
                    if ($request->aczts) {
                        $rules = [
                            'aczt' => 'required'
                        ];

                        foreach ($request->aczts as $_key => $_value) {
                            $request->aczts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->aczts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["aczts"] = [
                            "data" => $request->aczts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ADIT ---//
                    if ($request->adits) {
                        $rules = [
                            'adit' => 'required'
                        ];

                        foreach ($request->adits as $_key => $_value) {
                            $request->adits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->adits[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["adits"] = [
                            "data" => $request->adits,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- AEGT ---//
                    if ($request->aegts) {
                        $rules = [
                            'aegt' => 'required'
                        ];

                        foreach ($request->aegts as $_key => $_value) {
                            $request->adits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->adits[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["aegts"] = [
                            "data" => $request->aegts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- AEZT ---//
                    if ($request->aezts) {
                        $rules = [
                            'aezt' => 'required'
                        ];

                        foreach ($request->aezts as $_key => $_value) {
                            $request->adits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->adits[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["aezts"] = [
                            "data" => $request->aezts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- AGHT ---//
                    if ($request->aghts) {
                        $rules = [
                            'aght' => 'required'
                        ];

                        foreach ($request->aezts as $_key => $_value) {
                            $request->aghts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->aghts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["aghts"] = [
                            "data" => $request->aghts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- AOBT ---//
                    if ($request->aobts) {
                        $rules = [
                            'aobt' => 'required'
                        ];

                        foreach ($request->aobts as $_key => $_value) {
                            $request->aobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->aobts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["aobts"] = [
                            "data" => $request->aobts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ARDT ---//
                    if ($request->ardts) {
                        $rules = [
                            'ardt' => 'required'
                        ];

                        foreach ($request->ardts as $_key => $_value) {
                            $request->ardts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->ardts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["ardts"] = [
                            "data" => $request->ardts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ARZT ---//
                    if ($request->arzts) {
                        $rules = [
                            'arzt' => 'required'
                        ];

                        foreach ($request->arzts as $_key => $_value) {
                            $request->ardts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->ardts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["arzts"] = [
                            "data" => $request->arzts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- AZAT ---//
                    if ($request->azats) {
                        $rules = [
                            'azat' => 'required'
                        ];

                        foreach ($request->arzts as $_key => $_value) {
                            $request->azats[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->azats[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["azats"] = [
                            "data" => $request->azats,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ASBT ---//
                    if ($request->asbts) {
                        $rules = [
                            'asbt' => 'required'
                        ];

                        foreach ($request->asbts as $_key => $_value) {
                            $request->asbts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->asbts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["asbts"] = [
                            "data" => $request->asbts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ASRT ---//
                    if ($request->asrts) {
                        $rules = [
                            'asrt' => 'required'
                        ];

                        foreach ($request->asrts as $_key => $_value) {
                            $request->asrts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->asrts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["asrts"] = [
                            "data" => $request->asrts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ATETS ---//
                    if ($request->atets) {
                        $rules = [
                            'atet' => 'required'
                        ];

                        foreach ($request->atets as $_key => $_value) {
                            $request->atets[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->atets[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["atets"] = [
                            "data" => $request->atets,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ATST ---//
                    if ($request->atsts) {
                        $rules = [
                            'atst' => 'required'
                        ];

                        foreach ($request->atsts as $_key => $_value) {
                            $request->atsts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->atsts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["atsts"] = [
                            "data" => $request->atsts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ATOT ---//
                    if ($request->atots) {
                        $rules = [
                            'atot' => 'required'
                        ];

                        foreach ($request->atots as $_key => $_value) {
                            $request->atots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->atots[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["atots"] = [
                            "data" => $request->atots,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ATTT ---//
                    if ($request->attts) {
                        $rules = [
                            'attt' => 'required'
                        ];

                        foreach ($request->attts as $_key => $_value) {
                            $request->attts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->attts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["attts"] = [
                            "data" => $request->attts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- AXOT ---//
                    if ($request->axots) {
                        $rules = [
                            'axot' => 'required'
                        ];

                        foreach ($request->axots as $_key => $_value) {
                            $request->axots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->axots[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["axots"] = [
                            "data" => $request->axots,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- CTOT ---//
                    if ($request->ctots) {
                        $rules = [
                            'ctot' => 'required'
                        ];

                        foreach ($request->ctots as $_key => $_value) {
                            $request->ctots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->ctots[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["ctots"] = [
                            "data" => $request->ctots,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ECZT ---//
                    if ($request->eczts) {
                        $rules = [
                            'eczt' => 'required'
                        ];

                        foreach ($request->eczts as $_key => $_value) {
                            $request->eczts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->eczts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["eczts"] = [
                            "data" => $request->eczts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- EDIT ---//
                    if ($request->edits) {
                        $rules = [
                            'edit' => 'required'
                        ];

                        foreach ($request->edits as $_key => $_value) {
                            $request->edits[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->edits[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["edits"] = [
                            "data" => $request->edits,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- EEZT ---//
                    if ($request->eezts) {
                        $rules = [
                            'eezt' => 'required'
                        ];

                        foreach ($request->eezts as $_key => $_value) {
                            $request->eezts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->eezts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["eezts"] = [
                            "data" => $request->eezts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- EOBT ---//
                    if ($request->eobts) {
                        $rules = [
                            'eobt' => 'required'
                        ];

                        foreach ($request->eobts as $_key => $_value) {
                            $request->eobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->eobts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["eobts"] = [
                            "data" => $request->eobts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ERZT ---//
                    if ($request->erzts) {
                        $rules = [
                            'erzt' => 'required'
                        ];

                        foreach ($request->erzts as $_key => $_value) {
                            $request->erzts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->erzts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["erzts"] = [
                            "data" => $request->erzts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- ETOT ---//
                    if ($request->etots) {
                        $rules = [
                            'etot' => 'required'
                        ];

                        foreach ($request->etots as $_key => $_value) {
                            $request->etots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->etots[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["etots"] = [
                            "data" => $request->etots,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- EXOT ---//
                    if ($request->exots) {
                        $rules = [
                            'exot' => 'required'
                        ];

                        foreach ($request->exots as $_key => $_value) {
                            $request->exots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->exots[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["exots"] = [
                            "data" => $request->exots,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- SOBT ---//
                    if ($request->sobts) {
                        $rules = [
                            'sobt' => 'required'
                        ];

                        foreach ($request->sobts as $_key => $_value) {
                            $request->sobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->sobts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["sobts"] = [
                            "data" => $request->sobts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- STET ---//
                    if ($request->stets) {
                        $rules = [
                            'stet' => 'required'
                        ];

                        foreach ($request->stets as $_key => $_value) {
                            $request->stets[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->stets[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["stets"] = [
                            "data" => $request->stets,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- STST ---//
                    if ($request->ststs) {
                        $rules = [
                            'stst' => 'required'
                        ];

                        foreach ($request->ststs as $_key => $_value) {
                            $request->ststs[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->ststs[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["ststs"] = [
                            "data" => $request->ststs,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- TOBT ---//
                    if ($request->tobts) {
                        $rules = [
                            'tobt' => 'required'
                        ];

                        foreach ($request->tobts as $_key => $_value) {
                            $request->tobts[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->tobts[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["tobts"] = [
                            "data" => $request->tobts,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- TSAT ---//
                    if ($request->tsats) {
                        $rules = [
                            'tsat' => 'required'
                        ];

                        foreach ($request->tsats as $_key => $_value) {
                            $request->tsats[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->tsats[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["tsats"] = [
                            "data" => $request->tsats,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- TTOT ---//
                    if ($request->ttots) {
                        $rules = [
                            'ttot' => 'required'
                        ];

                        foreach ($request->ttots as $_key => $_value) {
                            $request->ttots[$_key] = $this->setAuditableInformationFromRequest($_value, $request);

                            $brokenRules = $departure->validate($rules, (object)$request->ttots[$_key]);

                            if ($brokenRules->fails()) {
                                foreach ($brokenRules->errors()->getMessages() as $__key => $__value) {
                                    foreach ($__value as $message) {
                                        $response->addErrorMessageResponse($message);
                                    }
                                }

                                return $response;
                            }
                        }

                        $relations["ttots"] = [
                            "data" => $request->ttots,
                            "method" => RelationMethodType::CREATE_MANY(),
                            "detach" => false
                        ];
                    }

                    //--- Departure Meta ---//
                    if ($request->departure_meta) {
                        $request->departure_meta->id = $departure->departureMeta->id ?? 0;
                        $departureMeta = $this->setAuditableInformationFromRequest((array)$request->departure_meta, $request);

                        $relations["departureMeta"] = [
                            "data" => $departureMeta,
                            "method" => RelationMethodType::PUSH()
                        ];
                    }

                    $departureResult = $unitOfWork->markDirtyAndSaveChange($this->_departureRepository, $departure, $relations);

                    $departure = $this->showDeparture($departureResult->id);

                    $response->dtoCollection()->push($departure->dto->toArray());
                }
            });

            $response->addInfoMessageResponse('Departures updated');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
