<?php

namespace App\Presentation\Http\Controllers\Api\Departure;

use App\Core\Service\Request\DatetimeRangeRequest;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Events\Broadcast\SendDepartureEvent;
use App\Events\Broadcast\SendDeparturesEvent;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Departure\IDepartureService;
use App\Service\Contracts\Departure\Request\CreateDepartureRequest;
use App\Service\Contracts\Departure\Request\UpdateDepartureRequest;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DepartureController extends ApiBaseController
{
    private IDepartureService $_departureService;

    public function __construct(IDepartureService $departureService)
    {
        $this->_departureService = $departureService;
    }

    /**
     * @OA\Post(
     *     path="/departures/list-search",
     *     operationId="actionDeparturesListSearch",
     *     tags={"Departure"},
     *     description="Departures list search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="filter_by",
     *                              description="Filter by property",
     *                              type="string",
     *                              example="sobt"
     *                          ),
     *                          @OA\Property(
     *                              property="start_date",
     *                              description="Start date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          ),
     *                          @OA\Property(
     *                              property="end_date",
     *                              description="End date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/ListSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GenericListSearchJsonResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="rows",
     *                          description="rows property",
     *                          type="array",
     *                          @OA\Items(ref="#/components/schemas/DepartureResponse")
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetDeparturesListSearch(Request $request)
    {
        $filterBy = $request->input('filter_by');
        $dateTimeRange = (!is_null($request->input('start_date')) && !is_null($request->input('end_date'))) ? new DatetimeRangeRequest(
            new DateTime($request->input('start_date')),
            new DateTime($request->input('end_date'))
        ) : null;

        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_departureService, 'getDeparturesListSearch'],
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]);
    }

    /**
     * @OA\Post(
     *     path="/departures/page-search",
     *     operationId="actionDeparturesPageSearch",
     *     tags={"Departure"},
     *     description="Departures page search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="filter_by",
     *                              description="Filter by property",
     *                              type="string",
     *                              example="sobt"
     *                          ),
     *                          @OA\Property(
     *                              property="start_date",
     *                              description="Start date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          ),
     *                          @OA\Property(
     *                              property="end_date",
     *                              description="End date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PageSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GenericPageSearchJsonResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="rows",
     *                          description="rows property",
     *                          type="array",
     *                          @OA\Items(ref="#/components/schemas/DepartureResponse")
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetDeparturesPageSearch(Request $request)
    {
        $filterBy = $request->input('filter_by');
        $dateTimeRange = (!is_null($request->input('start_date')) && !is_null($request->input('end_date'))) ? new DatetimeRangeRequest(
            new DateTime($request->input('start_date')),
            new DateTime($request->input('end_date'))
        ) : null;

        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_departureService, 'getDeparturesPageSearch'],
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]);
    }

    /**
     * @OA\Post(
     *     path="/history/departures/list-search",
     *     operationId="actionHistoryDeparturesListSearch",
     *     tags={"Departure"},
     *     description="History departures list search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="filter_by",
     *                              description="Filter by property",
     *                              type="string",
     *                              example="sobt"
     *                          ),
     *                          @OA\Property(
     *                              property="start_date",
     *                              description="Start date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          ),
     *                          @OA\Property(
     *                              property="end_date",
     *                              description="End date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/ListSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GenericListSearchJsonResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="rows",
     *                          description="rows property",
     *                          type="array",
     *                          @OA\Items(ref="#/components/schemas/DepartureHistoryResponse")
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetHistoryDeparturesListSearch(Request $request)
    {
        $filterBy = $request->input('filter_by');
        $dateTimeRange = (!is_null($request->input('start_date')) && !is_null($request->input('end_date'))) ? new DatetimeRangeRequest(
            new DateTime($request->input('start_date')),
            new DateTime($request->input('end_date'))
        ) : null;

        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_departureService, 'getHistoryDeparturesListSearch'],
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]);
    }

    /**
     * @OA\Post(
     *     path="/history/departures/page-search",
     *     operationId="actionHistoryDeparturesPageSearch",
     *     tags={"Departure"},
     *     description="History departures page search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="filter_by",
     *                              description="Filter by property",
     *                              type="string",
     *                              example="sobt"
     *                          ),
     *                          @OA\Property(
     *                              property="start_date",
     *                              description="Start date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          ),
     *                          @OA\Property(
     *                              property="end_date",
     *                              description="End date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="YYYY-MM-DD HH:MM:SS"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PageSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GenericPageSearchJsonResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="rows",
     *                          description="rows property",
     *                          type="array",
     *                          @OA\Items(ref="#/components/schemas/DepartureHistoryResponse")
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetHistoryDeparturesPageSearch(Request $request)
    {
        $filterBy = $request->input('filter_by');
        $dateTimeRange = (!is_null($request->input('start_date')) && !is_null($request->input('end_date'))) ? new DatetimeRangeRequest(
            new DateTime($request->input('start_date')),
            new DateTime($request->input('end_date'))
        ) : null;

        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_departureService, 'getHistoryDeparturesPageSearch'],
            ['filterBy' => $filterBy, 'dateTimeRange' => $dateTimeRange]);
    }

    /**
     * @OA\Post(
     *     path="/departures/ids",
     *     operationId="actionDeparturesByIds",
     *     tags={"Departure"},
     *     description="Departures by ids",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="ids",
     *                      description="Ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64",
     *                          example=1
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/DepartureResponse")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetDeparturesByIds(Request $request)
    {
        $ids = (array)$request->input('ids');

        $departures = $this->_departureService->getDepartures($ids);

        return $this->getDataJsonResponse($departures->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/departures/aodb/ids",
     *     operationId="actionDeparturesByAodbIds",
     *     tags={"Departure"},
     *     description="Departures by aodb ids",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="aodb_ids",
     *                      description="Aodb ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64",
     *                          example=1
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/DepartureResponse")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetDeparturesByAodbIds(Request $request)
    {
        $aodbIds = (array)$request->input('aodb_ids');

        $departures = $this->_departureService->getDeparturesByAodbIds($aodbIds);

        return $this->getDataJsonResponse($departures->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/departures/tobt-updated",
     *     operationId="actionDeparturesTobtUpdated",
     *     tags={"Departure"},
     *     description="Departures tobt updated",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="start_date",
     *                      description="Start date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="YYYY-MM-DD HH:MM:SS"
     *                  ),
     *                  @OA\Property(
     *                      property="end_date",
     *                      description="End date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="YYYY-MM-DD HH:MM:SS"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/DepartureTobtUpdatedResponse")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionGetDeparturesTobtUpdated(Request $request)
    {
        $dateTimeRange = (!is_null($request->input('start_date')) && !is_null($request->input('end_date'))) ? new DatetimeRangeRequest(
            new DateTime($request->input('start_date')),
            new DateTime($request->input('end_date'))
        ) : null;

        $getDeparturesTobtUpdatedResponse = $this->_departureService->getDepartureTobtsUpdated($dateTimeRange);

        if ($getDeparturesTobtUpdatedResponse->isError()) {
            return $this->getErrorJson($getDeparturesTobtUpdatedResponse);
        }

        return $this->getDataJsonResponse($getDeparturesTobtUpdatedResponse->getDto());
    }


    /**
     * @OA\Post(
     *     path="/departure",
     *     operationId="actionCreateDeparture",
     *     tags={"Departure"},
     *     description="Create departure",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateDepartureRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Departure created"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionCreateDeparture(Request $request)
    {
        $createDepartureRequest = new CreateDepartureRequest();

        $createDepartureRequest->aodb_id = (int)$request->input('aodb_id');
        $createDepartureRequest->airport_id = (int)$request->input('airport_id');
        $createDepartureRequest->flight_number = $request->input('flight_number') ?? null;
        $createDepartureRequest->flight_numberable_id = $request->input('flight_numberable_id') ?? null;
        $createDepartureRequest->flight_numberable_type = $request->input('flight_numberable_type') ?? null;
        $createDepartureRequest->call_sign = $request->input('call_sign') ?? null;
        $createDepartureRequest->nature = $request->input('nature') ?? null;
        $createDepartureRequest->natureable_id = $request->input('natureable_id') ?? null;
        $createDepartureRequest->natureable_type = $request->input('natureable_type') ?? null;
        $createDepartureRequest->acft = $request->input('acft') ?? null;
        $createDepartureRequest->acftable_id = $request->input('acftable_id') ?? null;
        $createDepartureRequest->acftable_type = $request->input('acftable_type') ?? null;
        $createDepartureRequest->register = $request->input('register') ?? null;
        $createDepartureRequest->registerable_id = $request->input('registerable_id') ?? null;
        $createDepartureRequest->registerable_type = $request->input('registerable_type') ?? null;
        $createDepartureRequest->stand = $request->input('stand') ?? null;
        $createDepartureRequest->standable_id = $request->input('standable_id') ?? null;
        $createDepartureRequest->standable_type = $request->input('standable_type') ?? null;
        $createDepartureRequest->gate_name = $request->input('gate_name') ?? null;
        $createDepartureRequest->gate_nameable_id = $request->input('gate_nameable_id') ?? null;
        $createDepartureRequest->gate_nameable_type = $request->input('gate_nameable_type') ?? null;
        $createDepartureRequest->gate_open = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('gate_open'))) ? new DateTime($request->input('gate_open')) : null;
        $createDepartureRequest->gate_openable_id = $request->input('gate_openable_id') ?? null;
        $createDepartureRequest->gate_openable_type = $request->input('gate_openable_type') ?? null;
        $createDepartureRequest->runway_actual = $request->input('runway_actual') ?? null;
        $createDepartureRequest->runway_actualable_id = $request->input('runway_actualable_id') ?? null;
        $createDepartureRequest->runway_actualable_type = $request->input('runway_actualable_type') ?? null;
        $createDepartureRequest->runway_estimated = $request->input('runway_estimated') ?? null;
        $createDepartureRequest->runway_estimatedable_id = $request->input('runway_estimatedable_id') ?? null;
        $createDepartureRequest->runway_estimatedable_type = $request->input('runway_estimatedable_type') ?? null;
        $createDepartureRequest->transit = $request->input('transit') ?? null;
        $createDepartureRequest->transitable_id = $request->input('transitable_id') ?? null;
        $createDepartureRequest->transitable_type = $request->input('transitable_type') ?? null;
        $createDepartureRequest->destination = $request->input('destination') ?? null;
        $createDepartureRequest->destinationable_id = $request->input('destinationable_id') ?? null;
        $createDepartureRequest->destinationable_type = $request->input('destinationable_type') ?? null;
        $createDepartureRequest->status = $request->input('status') ?? null;
        $createDepartureRequest->code_share = $request->input('code_share') ?? null;
        $createDepartureRequest->data_origin = $request->input('data_origin') ?? null;
        $createDepartureRequest->data_originable_id = $request->input('data_originable_id') ?? null;
        $createDepartureRequest->data_originable_type = $request->input('data_originable_type') ?? null;

        if ($request->input('acgts')) {
            $createDepartureRequest->acgts = (array)$request->input('acgts');
        }

        if ($request->input('aczts')) {
            $createDepartureRequest->aczts = (array)$request->input('aczts');
        }

        if ($request->input('adits')) {
            $createDepartureRequest->adits = (array)$request->input('adits');
        }

        if ($request->input('aegts')) {
            $createDepartureRequest->aegts = (array)$request->input('aegts');
        }

        if ($request->input('aezts')) {
            $createDepartureRequest->aezts = (array)$request->input('aezts');
        }

        if ($request->input('aghts')) {
            $createDepartureRequest->aghts = (array)$request->input('aghts');
        }

        if ($request->input('aobts')) {
            $createDepartureRequest->aobts = (array)$request->input('aobts');
        }

        if ($request->input('ardts')) {
            $createDepartureRequest->ardts = (array)$request->input('ardts');
        }

        if ($request->input('arzts')) {
            $createDepartureRequest->arzts = (array)$request->input('arzts');
        }

        if ($request->input('asats')) {
            $createDepartureRequest->asats = (array)$request->input('asats');
        }

        if ($request->input('asbts')) {
            $createDepartureRequest->asbts = (array)$request->input('asbts');
        }

        if ($request->input('asrts')) {
            $createDepartureRequest->asrts = (array)$request->input('asrts');
        }

        if ($request->input('atets')) {
            $createDepartureRequest->atets = (array)$request->input('atets');
        }

        if ($request->input('atsts')) {
            $createDepartureRequest->atsts = (array)$request->input('atsts');
        }

        if ($request->input('atots')) {
            $createDepartureRequest->atots = (array)$request->input('atots');
        }

        if ($request->input('attts')) {
            $createDepartureRequest->attts = (array)$request->input('attts');
        }

        if ($request->input('axots')) {
            $createDepartureRequest->axots = (array)$request->input('axots');
        }

        if ($request->input('ctots')) {
            $createDepartureRequest->ctots = (array)$request->input('ctots');
        }

        if ($request->input('eczts')) {
            $createDepartureRequest->eczts = (array)$request->input('eczts');
        }

        if ($request->input('edits')) {
            $createDepartureRequest->edits = (array)$request->input('edits');
        }

        if ($request->input('eezts')) {
            $createDepartureRequest->eezts = (array)$request->input('eezts');
        }

        if ($request->input('eobts')) {
            $createDepartureRequest->eobts = (array)$request->input('eobts');
        }

        if ($request->input('erzts')) {
            $createDepartureRequest->erzts = (array)$request->input('erzts');
        }

        if ($request->input('etots')) {
            $createDepartureRequest->etots = (array)$request->input('etots');
        }

        if ($request->input('exots')) {
            $createDepartureRequest->exots = (array)$request->input('exots');
        }

        if ($request->input('mttts')) {
            $createDepartureRequest->mttts = (array)$request->input('mttts');
        }

        if ($request->input('sobts')) {
            $createDepartureRequest->sobts = (array)$request->input('sobts');
        }

        if ($request->input('stets')) {
            $createDepartureRequest->stets = (array)$request->input('stets');
        }

        if ($request->input('ststs')) {
            $createDepartureRequest->ststs = (array)$request->input('ststs');
        }

        if ($request->input('tobts')) {
            $createDepartureRequest->tobts = (array)$request->input('tobts');
        }

        if ($request->input('tsats')) {
            $createDepartureRequest->tsats = (array)$request->input('tsats');
        }

        if ($request->input('ttots')) {
            $createDepartureRequest->ttots = (array)$request->input('ttots');
        }

        $createDepartureRequest->departure_meta = (object)$request->input('departure_meta');

        $this->setRequestAuthor($createDepartureRequest);

        $createDepartureResponse = $this->_departureService->createDeparture($createDepartureRequest);

        if ($createDepartureResponse->isError()) {
            return $this->getErrorJson($createDepartureResponse);
        }

        $createDepartureBroadcast = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $createDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($createDepartureBroadcast->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createDepartureResponse, $createDepartureResponse->dto);
    }

    /**
     * @OA\Post(
     *     path="/departures",
     *     operationId="actionCreateDepartures",
     *     tags={"Departure"},
     *     description="Create departures",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"departures"},
     *                  @OA\Property(
     *                      property="departures",
     *                      description="Departures property",
     *                      type="array",
     *                      @OA\Items(ref="#/components/schemas/CreateDepartureRequest")
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Departures created"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionCreateDepartures(Request $request)
    {
        $departures = $request->input('departures');

        $createDepartureRequests = new Collection();

        foreach ($departures as $departure) {
            $createDepartureRequest = new CreateDepartureRequest();

            if (is_array($departure)) {
                $departure = (object)$departure;
            }

            $createDepartureRequest->aodb_id = (int)$departure->aodb_id;
            $createDepartureRequest->airport_id = (int)$departure->airport_id;
            $createDepartureRequest->flight_number = (property_exists($departure, 'flight_number')) ? (string)$departure->flight_number : null;
            $createDepartureRequest->flight_numberable_id = (property_exists($departure, 'flight_numberable_id')) ? (int)$departure->flight_numberable_id : null;
            $createDepartureRequest->flight_numberable_type = (property_exists($departure, 'flight_numberable_type')) ? (string)$departure->flight_numberable_type : null;
            $createDepartureRequest->call_sign = (property_exists($departure, 'call_sign')) ? (string)$departure->call_sign : null;
            $createDepartureRequest->nature = (property_exists($departure, 'nature')) ? (string)$departure->nature : null;
            $createDepartureRequest->natureable_id = (property_exists($departure, 'natureable_id')) ? (int)$departure->natureable_id : null;
            $createDepartureRequest->natureable_type = (property_exists($departure, 'natureable_type')) ? (string)$departure->natureable_type : null;
            $createDepartureRequest->acft = (property_exists($departure, 'acft')) ? (string)$departure->acft : null;
            $createDepartureRequest->acftable_id = (property_exists($departure, 'acftable_id')) ? (int)$departure->acftable_id : null;
            $createDepartureRequest->acftable_type = (property_exists($departure, 'acftable_type')) ? (string)$departure->acftable_type : null;
            $createDepartureRequest->register = (property_exists($departure, 'register')) ? (string)$departure->register : null;
            $createDepartureRequest->registerable_id = (property_exists($departure, 'registerable_id')) ? (int)$departure->registerable_id : null;
            $createDepartureRequest->registerable_type = (property_exists($departure, 'registerable_type')) ? (int)$departure->registerable_type : null;
            $createDepartureRequest->stand = (property_exists($departure, 'stand')) ? (string)$departure->stand : null;
            $createDepartureRequest->standable_id = (property_exists($departure, 'standable_id')) ? (int)$departure->standable_id : null;
            $createDepartureRequest->standable_type = (property_exists($departure, 'standable_type')) ? (string)$departure->standable_type : null;
            $createDepartureRequest->gate_name = (property_exists($departure, 'gate_name')) ? (string)$departure->gate_name : null;
            $createDepartureRequest->gate_nameable_id = (property_exists($departure, 'gate_nameable_id')) ? (int)$departure->gate_nameable_id : null;
            $createDepartureRequest->gate_nameable_type = (property_exists($departure, 'gate_nameable_type')) ? (string)$departure->gate_nameable_type : null;
            $createDepartureRequest->gate_open = (property_exists($departure, 'gate_open') && DateTime::createFromFormat('Y-m-d H:i:s', $departure->gate_open)) ? new DateTime($departure->gate_open) : null;
            $createDepartureRequest->gate_openable_id = (property_exists($departure, 'gate_openable_id')) ? (int)$departure->gate_openable_id : null;
            $createDepartureRequest->gate_openable_type = (property_exists($departure, 'gate_openable_type')) ? (string)$departure->gate_openable_type : null;
            $createDepartureRequest->runway_actual = (property_exists($departure, 'runway_actual')) ? (string)$departure->runway_actual : null;
            $createDepartureRequest->runway_actualable_id = (property_exists($departure, 'runway_actualable_id')) ? (int)$departure->runway_actualable_id : null;
            $createDepartureRequest->runway_actualable_type = (property_exists($departure, 'runway_actualable_type')) ? (string)$departure->runway_actualable_type : null;
            $createDepartureRequest->runway_estimated = (property_exists($departure, 'runway_estimated')) ? (string)$departure->runway_estimated : null;
            $createDepartureRequest->runway_estimatedable_id = (property_exists($departure, 'runway_estimatedable_id')) ? (int)$departure->runway_estimatedable_id : null;
            $createDepartureRequest->runway_estimatedable_type = (property_exists($departure, 'runway_estimatedable_type')) ? (string)$departure->runway_estimatedable_type : null;
            $createDepartureRequest->transit = (property_exists($departure, 'transit')) ? (string)$departure->transit : null;
            $createDepartureRequest->transitable_id = (property_exists($departure, 'transitable_id')) ? (int)$departure->transitable_id : null;
            $createDepartureRequest->transitable_type = (property_exists($departure, 'transitable_type')) ? (string)$departure->transitable_type : null;
            $createDepartureRequest->destination = (property_exists($departure, 'destination')) ? (string)$departure->destination : null;
            $createDepartureRequest->destinationable_id = (property_exists($departure, 'destinationable_id')) ? (int)$departure->destinationable_id : null;
            $createDepartureRequest->destinationable_type = (property_exists($departure, 'destinationable_type')) ? (string)$departure->destinationable_type : null;
            $createDepartureRequest->status = (property_exists($departure, 'status')) ? (string)$departure->status : null;
            $createDepartureRequest->code_share = (property_exists($departure, 'code_share')) ? (string)$departure->code_share : null;
            $createDepartureRequest->data_origin = (property_exists($departure, 'data_origin')) ? (string)$departure->data_origin : null;
            $createDepartureRequest->data_originable_id = (property_exists($departure, 'data_originable_id')) ? (int)$departure->data_originable_id : null;
            $createDepartureRequest->data_originable_type = (property_exists($departure, 'data_originable_type')) ? (string)$departure->data_originable_type : null;

            if (property_exists($departure, 'acgts') && !is_null($departure->acgts)) {
                $createDepartureRequest->acgts = (array)$departure->acgts;
            }

            if (property_exists($departure, 'aczts') && !is_null($departure->aczts)) {
                $createDepartureRequest->aczts = (array)$departure->aczts;
            }

            if (property_exists($departure, 'aczts') && !is_null($departure->adits)) {
                $createDepartureRequest->adits = (array)$departure->adits;
            }

            if (property_exists($departure, 'aegts') && !is_null($departure->aegts)) {
                $createDepartureRequest->aegts = (array)$departure->aegts;
            }

            if (property_exists($departure, 'aezts') && !is_null($departure->aezts)) {
                $createDepartureRequest->aezts = (array)$departure->aezts;
            }

            if (property_exists($departure, 'aghts') && !is_null($departure->aghts)) {
                $createDepartureRequest->aghts = (array)$departure->aghts;
            }

            if (property_exists($departure, 'aobts') && !is_null($departure->aobts)) {
                $createDepartureRequest->aobts = (array)$departure->aobts;
            }

            if (property_exists($departure, 'ardts') && !is_null($departure->ardts)) {
                $createDepartureRequest->ardts = (array)$departure->ardts;
            }

            if (property_exists($departure, 'arzts') && !is_null($departure->arzts)) {
                $createDepartureRequest->arzts = (array)$departure->arzts;
            }

            if (property_exists($departure, 'asats') && !is_null($departure->asats)) {
                $createDepartureRequest->asats = (array)$departure->asats;
            }

            if (property_exists($departure, 'asbts') && !is_null($departure->asbts)) {
                $createDepartureRequest->asbts = (array)$departure->asbts;
            }

            if (property_exists($departure, 'asrts') && !is_null($departure->asrts)) {
                $createDepartureRequest->asrts = (array)$departure->asrts;
            }

            if (property_exists($departure, 'atets') && !is_null($departure->atets)) {
                $createDepartureRequest->atets = (array)$departure->atets;
            }

            if (property_exists($departure, 'atsts') && !is_null($departure->atsts)) {
                $createDepartureRequest->atsts = (array)$departure->atsts;
            }

            if (property_exists($departure, 'atots') && !is_null($departure->atots)) {
                $createDepartureRequest->atots = (array)$departure->atots;
            }

            if (property_exists($departure, 'attts') && !is_null($departure->attts)) {
                $createDepartureRequest->attts = (array)$departure->attts;
            }

            if (property_exists($departure, 'axots') && !is_null($departure->axots)) {
                $createDepartureRequest->axots = (array)$departure->axots;
            }

            if (property_exists($departure, 'ctots') && !is_null($departure->ctots)) {
                $createDepartureRequest->ctots = (array)$departure->ctots;
            }

            if (property_exists($departure, 'eczts') && !is_null($departure->eczts)) {
                $createDepartureRequest->eczts = (array)$departure->eczts;
            }

            if (property_exists($departure, 'edits') && !is_null($departure->edits)) {
                $createDepartureRequest->edits = (array)$departure->edits;
            }

            if (property_exists($departure, 'eezts') && !is_null($departure->eezts)) {
                $createDepartureRequest->eezts = (array)$departure->eezts;
            }

            if (property_exists($departure, 'eobts') && !is_null($departure->eobts)) {
                $createDepartureRequest->eobts = (array)$departure->eobts;
            }

            if (property_exists($departure, 'erzts') && !is_null($departure->erzts)) {
                $createDepartureRequest->erzts = (array)$departure->erzts;
            }

            if (property_exists($departure, 'etots') && !is_null($departure->etots)) {
                $createDepartureRequest->etots = (array)$departure->etots;
            }

            if (property_exists($departure, 'exots') && !is_null($departure->exots)) {
                $createDepartureRequest->exots = (array)$departure->exots;
            }

            if (property_exists($departure, 'mttts') && !is_null($departure->mttts)) {
                $createDepartureRequest->mttts = (array)$departure->mttts;
            }

            if (property_exists($departure, 'sobts') && !is_null($departure->sobts)) {
                $createDepartureRequest->sobts = (array)$departure->sobts;
            }

            if (property_exists($departure, 'stets') && !is_null($departure->stets)) {
                $createDepartureRequest->stets = (array)$departure->stets;
            }

            if (property_exists($departure, 'ststs') && !is_null($departure->ststs)) {
                $createDepartureRequest->ststs = (array)$departure->ststs;
            }

            if (property_exists($departure, 'tobts') && !is_null($departure->tobts)) {
                $createDepartureRequest->tobts = (array)$departure->tobts;
            }

            if (property_exists($departure, 'tsats') && !is_null($departure->tsats)) {
                $createDepartureRequest->tsats = (array)$departure->tsats;
            }

            if (property_exists($departure, 'ttots') && !is_null($departure->ttots)) {
                $createDepartureRequest->ttots = (array)$departure->ttots;
            }

            $createDepartureRequest->departure_meta = (object)$departure->departure_meta;

            $this->setRequestAuthor($createDepartureRequest);

            $createDepartureRequests->push($createDepartureRequest);
        }

        $createDepartureResponses = $this->_departureService->createDepartures($createDepartureRequests);

        if ($createDepartureResponses->isError()) {
            return $this->getErrorJson($createDepartureResponses);
        }

        $createDeparturesBroadcast = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $createDepartureResponses->dtoCollection()->toArray()
        ]);

        broadcast(new SendDeparturesEvent($createDeparturesBroadcast->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createDepartureResponses, $createDepartureResponses->dtoCollection());
    }


    /**
     * @OA\Put(
     *     path="/departure/{id}",
     *     operationId="actionUpdateDepartureById",
     *     tags={"Departure"},
     *     description="Update departure by id",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateDepartureRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Departure updated"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionUpdateDeparture(Request $request, int $id)
    {
        $updateDepartureRequest = new UpdateDepartureRequest();

        $updateDepartureRequest->id = $id;
        $updateDepartureRequest->aodb_id = 0;
        $updateDepartureRequest->airport_id = (int)$request->input('airport_id');
        $updateDepartureRequest->flight_number = $request->input('flight_number') ?? null;
        $updateDepartureRequest->flight_numberable_id = $request->input('flight_numberable_id') ?? null;
        $updateDepartureRequest->flight_numberable_type = $request->input('flight_numberable_type') ?? null;
        $updateDepartureRequest->call_sign = $request->input('call_sign') ?? null;
        $updateDepartureRequest->nature = $request->input('nature') ?? null;
        $updateDepartureRequest->natureable_id = $request->input('natureable_id') ?? null;
        $updateDepartureRequest->natureable_type = $request->input('natureable_type') ?? null;
        $updateDepartureRequest->acft = $request->input('acft') ?? null;
        $updateDepartureRequest->acftable_id = $request->input('acftable_id') ?? null;
        $updateDepartureRequest->acftable_type = $request->input('acftable_type') ?? null;
        $updateDepartureRequest->register = $request->input('register') ?? null;
        $updateDepartureRequest->registerable_id = $request->input('registerable_id') ?? null;
        $updateDepartureRequest->registerable_type = $request->input('registerable_type') ?? null;
        $updateDepartureRequest->stand = $request->input('stand') ?? null;
        $updateDepartureRequest->standable_id = $request->input('standable_id') ?? null;
        $updateDepartureRequest->standable_type = $request->input('standable_type') ?? null;
        $updateDepartureRequest->gate_name = $request->input('gate_name') ?? null;
        $updateDepartureRequest->gate_nameable_id = $request->input('gate_nameable_id') ?? null;
        $updateDepartureRequest->gate_nameable_type = $request->input('gate_nameable_type') ?? null;
        $updateDepartureRequest->gate_open = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('gate_open'))) ? new DateTime($request->input('gate_open')) : null;
        $updateDepartureRequest->gate_openable_id = $request->input('gate_openable_id') ?? null;
        $updateDepartureRequest->gate_openable_type = $request->input('gate_openable_type') ?? null;
        $updateDepartureRequest->runway_actual = $request->input('runway_actual') ?? null;
        $updateDepartureRequest->runway_actualable_id = $request->input('runway_actualable_id') ?? null;
        $updateDepartureRequest->runway_actualable_type = $request->input('runway_actualable_type') ?? null;
        $updateDepartureRequest->runway_estimated = $request->input('runway_estimated') ?? null;
        $updateDepartureRequest->runway_estimatedable_id = $request->input('runway_estimatedable_id') ?? null;
        $updateDepartureRequest->runway_estimatedable_type = $request->input('runway_estimatedable_type') ?? null;
        $updateDepartureRequest->transit = $request->input('transit') ?? null;
        $updateDepartureRequest->transitable_id = $request->input('transitable_id') ?? null;
        $updateDepartureRequest->transitable_type = $request->input('transitable_type') ?? null;
        $updateDepartureRequest->destination = $request->input('destination') ?? null;
        $updateDepartureRequest->destinationable_id = $request->input('destinationable_id') ?? null;
        $updateDepartureRequest->destinationable_type = $request->input('destinationable_type') ?? null;
        $updateDepartureRequest->status = $request->input('status') ?? null;
        $updateDepartureRequest->code_share = $request->input('code_share') ?? null;
        $updateDepartureRequest->data_origin = $request->input('data_origin') ?? null;
        $updateDepartureRequest->data_originable_id = $request->input('data_originable_id') ?? null;
        $updateDepartureRequest->data_originable_type = $request->input('data_originable_type') ?? null;

        if ($request->input('acgts')) {
            $updateDepartureRequest->acgts = (array)$request->input('acgts');
        }

        if ($request->input('aczts')) {
            $updateDepartureRequest->aczts = (array)$request->input('aczts');
        }

        if ($request->input('adits')) {
            $updateDepartureRequest->adits = (array)$request->input('adits');
        }

        if ($request->input('aegts')) {
            $updateDepartureRequest->aegts = (array)$request->input('aegts');
        }

        if ($request->input('aezts')) {
            $updateDepartureRequest->aezts = (array)$request->input('aezts');
        }

        if ($request->input('aghts')) {
            $updateDepartureRequest->aghts = (array)$request->input('aghts');
        }

        if ($request->input('aobts')) {
            $updateDepartureRequest->aobts = (array)$request->input('aobts');
        }

        if ($request->input('ardts')) {
            $updateDepartureRequest->ardts = (array)$request->input('ardts');
        }

        if ($request->input('arzts')) {
            $updateDepartureRequest->arzts = (array)$request->input('arzts');
        }

        if ($request->input('asats')) {
            $updateDepartureRequest->asats = (array)$request->input('asats');
        }

        if ($request->input('asbts')) {
            $updateDepartureRequest->asbts = (array)$request->input('asbts');
        }

        if ($request->input('asrts')) {
            $updateDepartureRequest->asrts = (array)$request->input('asrts');
        }

        if ($request->input('atets')) {
            $updateDepartureRequest->atets = (array)$request->input('atets');
        }

        if ($request->input('atsts')) {
            $updateDepartureRequest->atsts = (array)$request->input('atsts');
        }

        if ($request->input('atots')) {
            $updateDepartureRequest->atots = (array)$request->input('atots');
        }

        if ($request->input('attts')) {
            $updateDepartureRequest->attts = (array)$request->input('attts');
        }

        if ($request->input('axots')) {
            $updateDepartureRequest->axots = (array)$request->input('axots');
        }

        if ($request->input('ctots')) {
            $updateDepartureRequest->ctots = (array)$request->input('ctots');
        }

        if ($request->input('eczts')) {
            $updateDepartureRequest->eczts = (array)$request->input('eczts');
        }

        if ($request->input('edits')) {
            $updateDepartureRequest->edits = (array)$request->input('edits');
        }

        if ($request->input('eezts')) {
            $updateDepartureRequest->eezts = (array)$request->input('eezts');
        }

        if ($request->input('eobts')) {
            $updateDepartureRequest->eobts = (array)$request->input('eobts');
        }

        if ($request->input('erzts')) {
            $updateDepartureRequest->erzts = (array)$request->input('erzts');
        }

        if ($request->input('etots')) {
            $updateDepartureRequest->etots = (array)$request->input('etots');
        }

        if ($request->input('exots')) {
            $updateDepartureRequest->exots = (array)$request->input('exots');
        }

        if ($request->input('mttts')) {
            $updateDepartureRequest->mttts = (array)$request->input('mttts');
        }

        if ($request->input('sobts')) {
            $updateDepartureRequest->sobts = (array)$request->input('sobts');
        }

        if ($request->input('stets')) {
            $updateDepartureRequest->stets = (array)$request->input('stets');
        }

        if ($request->input('ststs')) {
            $updateDepartureRequest->ststs = (array)$request->input('ststs');
        }

        if ($request->input('tobts')) {
            $updateDepartureRequest->tobts = (array)$request->input('tobts');
        }

        if ($request->input('tsats')) {
            $updateDepartureRequest->tsats = (array)$request->input('tsats');
        }

        if ($request->input('ttots')) {
            $updateDepartureRequest->ttots = (array)$request->input('ttots');
        }

        if ($request->input('departure_meta')) {
            $updateDepartureRequest->departure_meta = (object)$request->input('departure_meta');
        }

        $this->setRequestAuthor($updateDepartureRequest);

        $updateDepartureResponse = $this->_departureService->updateDeparture($updateDepartureRequest);

        if ($updateDepartureResponse->isError()) {
            return $this->getErrorJson($updateDepartureResponse);
        }

        $updateDepartureBroadcast = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $updateDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($updateDepartureBroadcast->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($updateDepartureResponse, $updateDepartureResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/departures",
     *     operationId="actionUpdateDeparturesById",
     *     tags={"Departure"},
     *     description="Update departures by id",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"departures"},
     *                  @OA\Property(
     *                      property="departures",
     *                      description="Departures property",
     *                      type="array",
     *                      @OA\Items(
     *                          allOf={
     *                              @OA\Schema(ref="#/components/schemas/DepartureIdRequest"),
     *                              @OA\Schema(ref="#/components/schemas/UpdateDepartureRequest")
     *                          }
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Departures updated"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionUpdateDepartures(Request $request)
    {
        $departures = $request->input('departures');

        $updateDepartureRequests = new Collection();

        foreach ($departures as $departure) {
            $updateDepartureRequest = new UpdateDepartureRequest();

            if (is_array($departure)) {
                $departure = (object)$departure;
            }

            $updateDepartureRequest->id = (int)$departure->id;
            $updateDepartureRequest->aodb_id = 0;
            $updateDepartureRequest->airport_id = (int)$departure->airport_id;
            $updateDepartureRequest->flight_numberable_id = (property_exists($departure, 'flight_numberable_id')) ? (int)$departure->flight_numberable_id : null;
            $updateDepartureRequest->flight_numberable_type = (property_exists($departure, 'flight_numberable_type')) ? (string)$departure->flight_numberable_type : null;
            $updateDepartureRequest->call_sign = (property_exists($departure, 'call_sign')) ? (string)$departure->call_sign : null;
            $updateDepartureRequest->nature = (property_exists($departure, 'nature')) ? (string)$departure->nature : null;
            $updateDepartureRequest->natureable_id = (property_exists($departure, 'natureable_id')) ? (int)$departure->natureable_id : null;
            $updateDepartureRequest->natureable_type = (property_exists($departure, 'natureable_type')) ? (string)$departure->natureable_type : null;
            $updateDepartureRequest->acft = (property_exists($departure, 'acft')) ? (string)$departure->acft : null;
            $updateDepartureRequest->acftable_id = (property_exists($departure, 'acftable_id')) ? (int)$departure->acftable_id : null;
            $updateDepartureRequest->acftable_type = (property_exists($departure, 'acftable_type')) ? (string)$departure->acftable_type : null;
            $updateDepartureRequest->register = (property_exists($departure, 'register')) ? (string)$departure->register : null;
            $updateDepartureRequest->registerable_id = (property_exists($departure, 'registerable_id')) ? (int)$departure->registerable_id : null;
            $updateDepartureRequest->registerable_type = (property_exists($departure, 'registerable_type')) ? (int)$departure->registerable_type : null;
            $updateDepartureRequest->stand = (property_exists($departure, 'stand')) ? (string)$departure->stand : null;
            $updateDepartureRequest->standable_id = (property_exists($departure, 'standable_id')) ? (int)$departure->standable_id : null;
            $updateDepartureRequest->standable_type = (property_exists($departure, 'standable_type')) ? (string)$departure->standable_type : null;
            $updateDepartureRequest->gate_name = (property_exists($departure, 'gate_name')) ? (string)$departure->gate_name : null;
            $updateDepartureRequest->gate_nameable_id = (property_exists($departure, 'gate_nameable_id')) ? (int)$departure->gate_nameable_id : null;
            $updateDepartureRequest->gate_nameable_type = (property_exists($departure, 'gate_nameable_type')) ? (string)$departure->gate_nameable_type : null;
            $updateDepartureRequest->gate_open = (property_exists($departure, 'gate_open') && DateTime::createFromFormat('Y-m-d H:i:s', $departure->gate_open)) ? new DateTime($departure->gate_open) : null;
            $updateDepartureRequest->gate_openable_id = (property_exists($departure, 'gate_openable_id')) ? (int)$departure->gate_openable_id : null;
            $updateDepartureRequest->gate_openable_type = (property_exists($departure, 'gate_openable_type')) ? (string)$departure->gate_openable_type : null;
            $updateDepartureRequest->runway_actual = (property_exists($departure, 'runway_actual')) ? (string)$departure->runway_actual : null;
            $updateDepartureRequest->runway_actualable_id = (property_exists($departure, 'runway_actualable_id')) ? (int)$departure->runway_actualable_id : null;
            $updateDepartureRequest->runway_actualable_type = (property_exists($departure, 'runway_actualable_type')) ? (string)$departure->runway_actualable_type : null;
            $updateDepartureRequest->runway_estimated = (property_exists($departure, 'runway_estimated')) ? (string)$departure->runway_estimated : null;
            $updateDepartureRequest->runway_estimatedable_id = (property_exists($departure, 'runway_estimatedable_id')) ? (int)$departure->runway_estimatedable_id : null;
            $updateDepartureRequest->runway_estimatedable_type = (property_exists($departure, 'runway_estimatedable_type')) ? (string)$departure->runway_estimatedable_type : null;
            $updateDepartureRequest->transit = (property_exists($departure, 'transit')) ? (string)$departure->transit : null;
            $updateDepartureRequest->transitable_id = (property_exists($departure, 'transitable_id')) ? (int)$departure->transitable_id : null;
            $updateDepartureRequest->transitable_type = (property_exists($departure, 'transitable_type')) ? (string)$departure->transitable_type : null;
            $updateDepartureRequest->destination = (property_exists($departure, 'destination')) ? (string)$departure->destination : null;
            $updateDepartureRequest->destinationable_id = (property_exists($departure, 'destinationable_id')) ? (int)$departure->destinationable_id : null;
            $updateDepartureRequest->destinationable_type = (property_exists($departure, 'destinationable_type')) ? (string)$departure->destinationable_type : null;
            $updateDepartureRequest->status = (property_exists($departure, 'status')) ? (string)$departure->status : null;
            $updateDepartureRequest->code_share = (property_exists($departure, 'code_share')) ? (string)$departure->code_share : null;
            $updateDepartureRequest->data_origin = (property_exists($departure, 'data_origin')) ? (string)$departure->data_origin : null;
            $updateDepartureRequest->data_originable_id = (property_exists($departure, 'data_originable_id')) ? (int)$departure->data_originable_id : null;
            $updateDepartureRequest->data_originable_type = (property_exists($departure, 'data_originable_type')) ? (string)$departure->data_originable_type : null;

            if (property_exists($departure, 'acgts') && !is_null($departure->acgts)) {
                $updateDepartureRequest->acgts = (array)$departure->acgts;
            }

            if (property_exists($departure, 'aczts') && !is_null($departure->aczts)) {
                $updateDepartureRequest->aczts = (array)$departure->aczts;
            }

            if (property_exists($departure, 'aczts') && !is_null($departure->adits)) {
                $updateDepartureRequest->adits = (array)$departure->adits;
            }

            if (property_exists($departure, 'aegts') && !is_null($departure->aegts)) {
                $updateDepartureRequest->aegts = (array)$departure->aegts;
            }

            if (property_exists($departure, 'aezts') && !is_null($departure->aezts)) {
                $updateDepartureRequest->aezts = (array)$departure->aezts;
            }

            if (property_exists($departure, 'aghts') && !is_null($departure->aghts)) {
                $updateDepartureRequest->aghts = (array)$departure->aghts;
            }

            if (property_exists($departure, 'aobts') && !is_null($departure->aobts)) {
                $updateDepartureRequest->aobts = (array)$departure->aobts;
            }

            if (property_exists($departure, 'ardts') && !is_null($departure->ardts)) {
                $updateDepartureRequest->ardts = (array)$departure->ardts;
            }

            if (property_exists($departure, 'arzts') && !is_null($departure->arzts)) {
                $updateDepartureRequest->arzts = (array)$departure->arzts;
            }

            if (property_exists($departure, 'asats') && !is_null($departure->asats)) {
                $updateDepartureRequest->asats = (array)$departure->asats;
            }

            if (property_exists($departure, 'asbts') && !is_null($departure->asbts)) {
                $updateDepartureRequest->asbts = (array)$departure->asbts;
            }

            if (property_exists($departure, 'asrts') && !is_null($departure->asrts)) {
                $updateDepartureRequest->asrts = (array)$departure->asrts;
            }

            if (property_exists($departure, 'atets') && !is_null($departure->atets)) {
                $updateDepartureRequest->atets = (array)$departure->atets;
            }

            if (property_exists($departure, 'atsts') && !is_null($departure->atsts)) {
                $updateDepartureRequest->atsts = (array)$departure->atsts;
            }

            if (property_exists($departure, 'atots') && !is_null($departure->atots)) {
                $updateDepartureRequest->atots = (array)$departure->atots;
            }

            if (property_exists($departure, 'attts') && !is_null($departure->attts)) {
                $updateDepartureRequest->attts = (array)$departure->attts;
            }

            if (property_exists($departure, 'axots') && !is_null($departure->axots)) {
                $updateDepartureRequest->axots = (array)$departure->axots;
            }

            if (property_exists($departure, 'ctots') && !is_null($departure->ctots)) {
                $updateDepartureRequest->ctots = (array)$departure->ctots;
            }

            if (property_exists($departure, 'eczts') && !is_null($departure->eczts)) {
                $updateDepartureRequest->eczts = (array)$departure->eczts;
            }

            if (property_exists($departure, 'edits') && !is_null($departure->edits)) {
                $updateDepartureRequest->edits = (array)$departure->edits;
            }

            if (property_exists($departure, 'eezts') && !is_null($departure->eezts)) {
                $updateDepartureRequest->eezts = (array)$departure->eezts;
            }

            if (property_exists($departure, 'eobts') && !is_null($departure->eobts)) {
                $updateDepartureRequest->eobts = (array)$departure->eobts;
            }

            if (property_exists($departure, 'erzts') && !is_null($departure->erzts)) {
                $updateDepartureRequest->erzts = (array)$departure->erzts;
            }

            if (property_exists($departure, 'etots') && !is_null($departure->etots)) {
                $updateDepartureRequest->etots = (array)$departure->etots;
            }

            if (property_exists($departure, 'exots') && !is_null($departure->exots)) {
                $updateDepartureRequest->exots = (array)$departure->exots;
            }

            if (property_exists($departure, 'mttts') && !is_null($departure->mttts)) {
                $updateDepartureRequest->mttts = (array)$departure->mttts;
            }

            if (property_exists($departure, 'sobts') && !is_null($departure->sobts)) {
                $updateDepartureRequest->sobts = (array)$departure->sobts;
            }

            if (property_exists($departure, 'stets') && !is_null($departure->stets)) {
                $updateDepartureRequest->stets = (array)$departure->stets;
            }

            if (property_exists($departure, 'ststs') && !is_null($departure->ststs)) {
                $updateDepartureRequest->ststs = (array)$departure->ststs;
            }

            if (property_exists($departure, 'tobts') && !is_null($departure->tobts)) {
                $updateDepartureRequest->tobts = (array)$departure->tobts;
            }

            if (property_exists($departure, 'tsats') && !is_null($departure->tsats)) {
                $updateDepartureRequest->tsats = (array)$departure->tsats;
            }

            if (property_exists($departure, 'ttots') && !is_null($departure->ttots)) {
                $updateDepartureRequest->ttots = (array)$departure->ttots;
            }

            if (property_exists($departure, 'departure_meta') && !is_null($departure->departure_meta)) {
                $updateDepartureRequest->departure_meta = (object)$departure->departure_meta;
            }

            $this->setRequestAuthor($updateDepartureRequest);

            $updateDepartureRequests->push($updateDepartureRequest);
        }

        $updateDepartureResponse = $this->_departureService->updateDepartures($updateDepartureRequests);

        if ($updateDepartureResponse->isError()) {
            return $this->getErrorJson($updateDepartureResponse);
        }

        $updateDeparturesBroadcast = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $updateDepartureResponse->dtoCollection()->toArray()
        ]);

        broadcast(new SendDeparturesEvent($updateDeparturesBroadcast->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($updateDepartureResponse, $updateDepartureResponse->dtoCollection());
    }

    /**
     * @OA\Put(
     *     path="/departure/aodb/{id}",
     *     operationId="actionUpdateDepartureByAodbId",
     *     tags={"Departure"},
     *     description="Update departure by aodb id",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="aodbId",
     *          in="path",
     *          description="Aodb id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateDepartureRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Departure updated"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $aodbId
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionUpdateDepartureByAodbId(Request $request, int $aodbId)
    {
        $updateDepartureRequest = new UpdateDepartureRequest();

        $updateDepartureRequest->id = 0;
        $updateDepartureRequest->aodb_id = $aodbId;
        $updateDepartureRequest->airport_id = (int)$request->input('airport_id');
        $updateDepartureRequest->flight_number = (string)$request->input('flight_number') ?? null;
        $updateDepartureRequest->flight_numberable_id = (int)$request->input('flight_numberable_id') ?? null;
        $updateDepartureRequest->flight_numberable_type = (string)$request->input('flight_numberable_type') ?? null;
        $updateDepartureRequest->call_sign = (string)$request->input('call_sign') ?? null;
        $updateDepartureRequest->nature = (string)$request->input('nature') ?? null;
        $updateDepartureRequest->natureable_id = (int)$request->input('natureable_id') ?? null;
        $updateDepartureRequest->natureable_type = (string)$request->input('natureable_type') ?? null;
        $updateDepartureRequest->acft = (string)$request->input('acft') ?? null;
        $updateDepartureRequest->acftable_id = (int)$request->input('acftable_id') ?? null;
        $updateDepartureRequest->acftable_type = (string)$request->input('acftable_type') ?? null;
        $updateDepartureRequest->register = (string)$request->input('register') ?? null;
        $updateDepartureRequest->registerable_id = (int)$request->input('registerable_id') ?? null;
        $updateDepartureRequest->registerable_type = (string)$request->input('registerable_type') ?? null;
        $updateDepartureRequest->stand = (string)$request->input('stand') ?? null;
        $updateDepartureRequest->standable_id = (int)$request->input('standable_id') ?? null;
        $updateDepartureRequest->standable_type = (string)$request->input('standable_type') ?? null;
        $updateDepartureRequest->gate_name = (string)$request->input('gate_name') ?? null;
        $updateDepartureRequest->gate_nameable_id = (int)$request->input('gate_nameable_id') ?? null;
        $updateDepartureRequest->gate_nameable_type = (string)$request->input('gate_nameable_type') ?? null;
        $updateDepartureRequest->gate_open = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('gate_open'))) ? new DateTime($request->input('gate_open')) : null;
        $updateDepartureRequest->gate_openable_id = (int)$request->input('gate_openable_id') ?? null;
        $updateDepartureRequest->gate_openable_type = (string)$request->input('gate_openable_type') ?? null;
        $updateDepartureRequest->runway_actual = (string)$request->input('runway_actual') ?? null;
        $updateDepartureRequest->runway_actualable_id = (int)$request->input('runway_actualable_id') ?? null;
        $updateDepartureRequest->runway_actualable_type = (string)$request->input('runway_actualable_type') ?? null;
        $updateDepartureRequest->runway_estimated = (string)$request->input('runway_estimated') ?? null;
        $updateDepartureRequest->runway_estimatedable_id = (int)$request->input('runway_estimatedable_id') ?? null;
        $updateDepartureRequest->runway_estimatedable_type = (string)$request->input('runway_estimatedable_type') ?? null;
        $updateDepartureRequest->transit = (string)$request->input('transit') ?? null;
        $updateDepartureRequest->transitable_id = (int)$request->input('transitable_id') ?? null;
        $updateDepartureRequest->transitable_type = (string)$request->input('transitable_type') ?? null;
        $updateDepartureRequest->destination = (string)$request->input('destination') ?? null;
        $updateDepartureRequest->destinationable_id = (int)$request->input('destinationable_id') ?? null;
        $updateDepartureRequest->destinationable_type = (string)$request->input('destinationable_type') ?? null;
        $updateDepartureRequest->status = (string)$request->input('status') ?? null;
        $updateDepartureRequest->code_share = (string)$request->input('code_share') ?? null;
        $updateDepartureRequest->data_origin = (string)$request->input('data_origin') ?? null;
        $updateDepartureRequest->data_originable_id = (int)$request->input('data_originable_id') ?? null;
        $updateDepartureRequest->data_originable_type = (string)$request->input('data_originable_type') ?? null;

        if ($request->input('acgts')) {
            $updateDepartureRequest->acgts = (array)$request->input('acgts');
        }

        if ($request->input('aczts')) {
            $updateDepartureRequest->aczts = (array)$request->input('aczts');
        }

        if ($request->input('adits')) {
            $updateDepartureRequest->adits = (array)$request->input('adits');
        }

        if ($request->input('aegts')) {
            $updateDepartureRequest->aegts = (array)$request->input('aegts');
        }

        if ($request->input('aezts')) {
            $updateDepartureRequest->aezts = (array)$request->input('aezts');
        }

        if ($request->input('aghts')) {
            $updateDepartureRequest->aghts = (array)$request->input('aghts');
        }

        if ($request->input('aobts')) {
            $updateDepartureRequest->aobts = (array)$request->input('aobts');
        }

        if ($request->input('ardts')) {
            $updateDepartureRequest->ardts = (array)$request->input('ardts');
        }

        if ($request->input('arzts')) {
            $updateDepartureRequest->arzts = (array)$request->input('arzts');
        }

        if ($request->input('asats')) {
            $updateDepartureRequest->asats = (array)$request->input('asats');
        }

        if ($request->input('asbts')) {
            $updateDepartureRequest->asbts = (array)$request->input('asbts');
        }

        if ($request->input('asrts')) {
            $updateDepartureRequest->asrts = (array)$request->input('asrts');
        }

        if ($request->input('atets')) {
            $updateDepartureRequest->atets = (array)$request->input('atets');
        }

        if ($request->input('atsts')) {
            $updateDepartureRequest->atsts = (array)$request->input('atsts');
        }

        if ($request->input('atots')) {
            $updateDepartureRequest->atots = (array)$request->input('atots');
        }

        if ($request->input('attts')) {
            $updateDepartureRequest->attts = (array)$request->input('attts');
        }

        if ($request->input('axots')) {
            $updateDepartureRequest->axots = (array)$request->input('axots');
        }

        if ($request->input('ctots')) {
            $updateDepartureRequest->ctots = (array)$request->input('ctots');
        }

        if ($request->input('eczts')) {
            $updateDepartureRequest->eczts = (array)$request->input('eczts');
        }

        if ($request->input('edits')) {
            $updateDepartureRequest->edits = (array)$request->input('edits');
        }

        if ($request->input('eezts')) {
            $updateDepartureRequest->eezts = (array)$request->input('eezts');
        }

        if ($request->input('eobts')) {
            $updateDepartureRequest->eobts = (array)$request->input('eobts');
        }

        if ($request->input('erzts')) {
            $updateDepartureRequest->erzts = (array)$request->input('erzts');
        }

        if ($request->input('etots')) {
            $updateDepartureRequest->etots = (array)$request->input('etots');
        }

        if ($request->input('exots')) {
            $updateDepartureRequest->exots = (array)$request->input('exots');
        }

        if ($request->input('mttts')) {
            $updateDepartureRequest->mttts = (array)$request->input('mttts');
        }

        if ($request->input('sobts')) {
            $updateDepartureRequest->sobts = (array)$request->input('sobts');
        }

        if ($request->input('stets')) {
            $updateDepartureRequest->stets = (array)$request->input('stets');
        }

        if ($request->input('ststs')) {
            $updateDepartureRequest->ststs = (array)$request->input('ststs');
        }

        if ($request->input('tobts')) {
            $updateDepartureRequest->tobts = (array)$request->input('tobts');
        }

        if ($request->input('tsats')) {
            $updateDepartureRequest->tsats = (array)$request->input('tsats');
        }

        if ($request->input('ttots')) {
            $updateDepartureRequest->ttots = (array)$request->input('ttots');
        }

        if ($request->input('departure_meta')) {
            $updateDepartureRequest->departure_meta = (object)$request->input('departure_meta');
        }

        $this->setRequestAuthor($updateDepartureRequest);

        $updateDepartureResponse = $this->_departureService->updateDeparture($updateDepartureRequest);

        if ($updateDepartureResponse->isError()) {
            return $this->getErrorJson($updateDepartureResponse);
        }

        $updateDepartureBroadcast = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $updateDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($updateDepartureBroadcast->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($updateDepartureResponse, $updateDepartureResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/departures/aodb",
     *     operationId="actionUpdateDeparturesByAodbId",
     *     tags={"Departure"},
     *     description="Update departures by aodb id",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"departures"},
     *                  @OA\Property(
     *                      property="departures",
     *                      description="Departures property",
     *                      type="array",
     *                      @OA\Items(
     *                          allOf={
     *                              @OA\Schema(ref="#/components/schemas/DepartureAodbIdRequest"),
     *                              @OA\Schema(ref="#/components/schemas/UpdateDepartureRequest")
     *                          }
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Departures updated"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function actionUpdateDeparturesByAodbIds(Request $request)
    {
        $departures = $request->input('departures');

        $updateDepartureRequests = new Collection();

        foreach ($departures as $departure) {
            $updateDepartureRequest = new UpdateDepartureRequest();

            if (is_array($departure)) {
                $departure = (object)$departure;
            }

            $updateDepartureRequest->id = 0;
            $updateDepartureRequest->aodb_id = (int)$departure->aodb_id;
            $updateDepartureRequest->airport_id = (int)$departure->airport_id;
            $updateDepartureRequest->flight_numberable_id = (property_exists($departure, 'flight_numberable_id')) ? (int)$departure->flight_numberable_id : null;
            $updateDepartureRequest->flight_numberable_type = (property_exists($departure, 'flight_numberable_type')) ? (string)$departure->flight_numberable_type : null;
            $updateDepartureRequest->call_sign = (property_exists($departure, 'call_sign')) ? (string)$departure->call_sign : null;
            $updateDepartureRequest->nature = (property_exists($departure, 'nature')) ? (string)$departure->nature : null;
            $updateDepartureRequest->natureable_id = (property_exists($departure, 'natureable_id')) ? (int)$departure->natureable_id : null;
            $updateDepartureRequest->natureable_type = (property_exists($departure, 'natureable_type')) ? (string)$departure->natureable_type : null;
            $updateDepartureRequest->acft = (property_exists($departure, 'acft')) ? (string)$departure->acft : null;
            $updateDepartureRequest->acftable_id = (property_exists($departure, 'acftable_id')) ? (int)$departure->acftable_id : null;
            $updateDepartureRequest->acftable_type = (property_exists($departure, 'acftable_type')) ? (string)$departure->acftable_type : null;
            $updateDepartureRequest->register = (property_exists($departure, 'register')) ? (string)$departure->register : null;
            $updateDepartureRequest->registerable_id = (property_exists($departure, 'registerable_id')) ? (int)$departure->registerable_id : null;
            $updateDepartureRequest->registerable_type = (property_exists($departure, 'registerable_type')) ? (int)$departure->registerable_type : null;
            $updateDepartureRequest->stand = (property_exists($departure, 'stand')) ? (string)$departure->stand : null;
            $updateDepartureRequest->standable_id = (property_exists($departure, 'standable_id')) ? (int)$departure->standable_id : null;
            $updateDepartureRequest->standable_type = (property_exists($departure, 'standable_type')) ? (string)$departure->standable_type : null;
            $updateDepartureRequest->gate_name = (property_exists($departure, 'gate_name')) ? (string)$departure->gate_name : null;
            $updateDepartureRequest->gate_nameable_id = (property_exists($departure, 'gate_nameable_id')) ? (int)$departure->gate_nameable_id : null;
            $updateDepartureRequest->gate_nameable_type = (property_exists($departure, 'gate_nameable_type')) ? (string)$departure->gate_nameable_type : null;
            $updateDepartureRequest->gate_open = (property_exists($departure, 'gate_open') && DateTime::createFromFormat('Y-m-d H:i:s', $departure->gate_open)) ? new DateTime($departure->gate_open) : null;
            $updateDepartureRequest->gate_openable_id = (property_exists($departure, 'gate_openable_id')) ? (int)$departure->gate_openable_id : null;
            $updateDepartureRequest->gate_openable_type = (property_exists($departure, 'gate_openable_type')) ? (string)$departure->gate_openable_type : null;
            $updateDepartureRequest->runway_actual = (property_exists($departure, 'runway_actual')) ? (string)$departure->runway_actual : null;
            $updateDepartureRequest->runway_actualable_id = (property_exists($departure, 'runway_actualable_id')) ? (int)$departure->runway_actualable_id : null;
            $updateDepartureRequest->runway_actualable_type = (property_exists($departure, 'runway_actualable_type')) ? (string)$departure->runway_actualable_type : null;
            $updateDepartureRequest->runway_estimated = (property_exists($departure, 'runway_estimated')) ? (string)$departure->runway_estimated : null;
            $updateDepartureRequest->runway_estimatedable_id = (property_exists($departure, 'runway_estimatedable_id')) ? (int)$departure->runway_estimatedable_id : null;
            $updateDepartureRequest->runway_estimatedable_type = (property_exists($departure, 'runway_estimatedable_type')) ? (string)$departure->runway_estimatedable_type : null;
            $updateDepartureRequest->transit = (property_exists($departure, 'transit')) ? (string)$departure->transit : null;
            $updateDepartureRequest->transitable_id = (property_exists($departure, 'transitable_id')) ? (int)$departure->transitable_id : null;
            $updateDepartureRequest->transitable_type = (property_exists($departure, 'transitable_type')) ? (string)$departure->transitable_type : null;
            $updateDepartureRequest->destination = (property_exists($departure, 'destination')) ? (string)$departure->destination : null;
            $updateDepartureRequest->destinationable_id = (property_exists($departure, 'destinationable_id')) ? (int)$departure->destinationable_id : null;
            $updateDepartureRequest->destinationable_type = (property_exists($departure, 'destinationable_type')) ? (string)$departure->destinationable_type : null;
            $updateDepartureRequest->status = (property_exists($departure, 'status')) ? (string)$departure->status : null;
            $updateDepartureRequest->code_share = (property_exists($departure, 'code_share')) ? (string)$departure->code_share : null;
            $updateDepartureRequest->data_origin = (property_exists($departure, 'data_origin')) ? (string)$departure->data_origin : null;
            $updateDepartureRequest->data_originable_id = (property_exists($departure, 'data_originable_id')) ? (int)$departure->data_originable_id : null;
            $updateDepartureRequest->data_originable_type = (property_exists($departure, 'data_originable_type')) ? (string)$departure->data_originable_type : null;

            if (property_exists($departure, 'acgts') && !is_null($departure->acgts)) {
                $updateDepartureRequest->acgts = (array)$departure->acgts;
            }

            if (property_exists($departure, 'aczts') && !is_null($departure->aczts)) {
                $updateDepartureRequest->aczts = (array)$departure->aczts;
            }

            if (property_exists($departure, 'aczts') && !is_null($departure->adits)) {
                $updateDepartureRequest->adits = (array)$departure->adits;
            }

            if (property_exists($departure, 'aegts') && !is_null($departure->aegts)) {
                $updateDepartureRequest->aegts = (array)$departure->aegts;
            }

            if (property_exists($departure, 'aezts') && !is_null($departure->aezts)) {
                $updateDepartureRequest->aezts = (array)$departure->aezts;
            }

            if (property_exists($departure, 'aghts') && !is_null($departure->aghts)) {
                $updateDepartureRequest->aghts = (array)$departure->aghts;
            }

            if (property_exists($departure, 'aobts') && !is_null($departure->aobts)) {
                $updateDepartureRequest->aobts = (array)$departure->aobts;
            }

            if (property_exists($departure, 'ardts') && !is_null($departure->ardts)) {
                $updateDepartureRequest->ardts = (array)$departure->ardts;
            }

            if (property_exists($departure, 'arzts') && !is_null($departure->arzts)) {
                $updateDepartureRequest->arzts = (array)$departure->arzts;
            }

            if (property_exists($departure, 'asats') && !is_null($departure->asats)) {
                $updateDepartureRequest->asats = (array)$departure->asats;
            }

            if (property_exists($departure, 'asbts') && !is_null($departure->asbts)) {
                $updateDepartureRequest->asbts = (array)$departure->asbts;
            }

            if (property_exists($departure, 'asrts') && !is_null($departure->asrts)) {
                $updateDepartureRequest->asrts = (array)$departure->asrts;
            }

            if (property_exists($departure, 'atets') && !is_null($departure->atets)) {
                $updateDepartureRequest->atets = (array)$departure->atets;
            }

            if (property_exists($departure, 'atsts') && !is_null($departure->atsts)) {
                $updateDepartureRequest->atsts = (array)$departure->atsts;
            }

            if (property_exists($departure, 'atots') && !is_null($departure->atots)) {
                $updateDepartureRequest->atots = (array)$departure->atots;
            }

            if (property_exists($departure, 'attts') && !is_null($departure->attts)) {
                $updateDepartureRequest->attts = (array)$departure->attts;
            }

            if (property_exists($departure, 'axots') && !is_null($departure->axots)) {
                $updateDepartureRequest->axots = (array)$departure->axots;
            }

            if (property_exists($departure, 'ctots') && !is_null($departure->ctots)) {
                $updateDepartureRequest->ctots = (array)$departure->ctots;
            }

            if (property_exists($departure, 'eczts') && !is_null($departure->eczts)) {
                $updateDepartureRequest->eczts = (array)$departure->eczts;
            }

            if (property_exists($departure, 'edits') && !is_null($departure->edits)) {
                $updateDepartureRequest->edits = (array)$departure->edits;
            }

            if (property_exists($departure, 'eezts') && !is_null($departure->eezts)) {
                $updateDepartureRequest->eezts = (array)$departure->eezts;
            }

            if (property_exists($departure, 'eobts') && !is_null($departure->eobts)) {
                $updateDepartureRequest->eobts = (array)$departure->eobts;
            }

            if (property_exists($departure, 'erzts') && !is_null($departure->erzts)) {
                $updateDepartureRequest->erzts = (array)$departure->erzts;
            }

            if (property_exists($departure, 'etots') && !is_null($departure->etots)) {
                $updateDepartureRequest->etots = (array)$departure->etots;
            }

            if (property_exists($departure, 'exots') && !is_null($departure->exots)) {
                $updateDepartureRequest->exots = (array)$departure->exots;
            }

            if (property_exists($departure, 'mttts') && !is_null($departure->mttts)) {
                $updateDepartureRequest->mttts = (array)$departure->mttts;
            }

            if (property_exists($departure, 'sobts') && !is_null($departure->sobts)) {
                $updateDepartureRequest->sobts = (array)$departure->sobts;
            }

            if (property_exists($departure, 'stets') && !is_null($departure->stets)) {
                $updateDepartureRequest->stets = (array)$departure->stets;
            }

            if (property_exists($departure, 'ststs') && !is_null($departure->ststs)) {
                $updateDepartureRequest->ststs = (array)$departure->ststs;
            }

            if (property_exists($departure, 'tobts') && !is_null($departure->tobts)) {
                $updateDepartureRequest->tobts = (array)$departure->tobts;
            }

            if (property_exists($departure, 'tsats') && !is_null($departure->tsats)) {
                $updateDepartureRequest->tsats = (array)$departure->tsats;
            }

            if (property_exists($departure, 'ttots') && !is_null($departure->ttots)) {
                $updateDepartureRequest->ttots = (array)$departure->ttots;
            }

            if (property_exists($departure, 'departure_meta') && !is_null($departure->departure_meta)) {
                $updateDepartureRequest->departure_meta = (object)$departure->departure_meta;
            }

            $this->setRequestAuthor($updateDepartureRequest);

            $updateDepartureRequests->push($updateDepartureRequest);
        }

        $updateDepartureResponse = $this->_departureService->updateDepartures($updateDepartureRequests);

        if ($updateDepartureResponse->isError()) {
            return $this->getErrorJson($updateDepartureResponse);
        }

        $updateDeparturesBroadcast = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $updateDepartureResponse->dtoCollection()->toArray()
        ]);

        broadcast(new SendDeparturesEvent($updateDeparturesBroadcast->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($updateDepartureResponse, $updateDepartureResponse->dtoCollection());
    }


    /**
     * @OA\Get(
     *     path="/departure/{id}",
     *     operationId="actionShowDeparture",
     *     tags={"Departure"},
     *     description="Show departure",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/DepartureResponse")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowDeparture(int $id)
    {
        $departureResponse = $this->_departureService->showDeparture($id);

        if ($departureResponse->isError()) {
            return $this->getErrorJson($departureResponse);
        }

        return $this->getDataJsonResponse($departureResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/departure/aodb/{id}",
     *     operationId="actionShowDepartureByAodbId",
     *     tags={"Departure"},
     *     description="Show departure by aodb id",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/DepartureResponse")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowDepartureByAodbId(int $id)
    {
        $departureResponse = $this->_departureService->showDepartureByAodbId($id);

        if ($departureResponse->isError()) {
            return $this->getErrorJson($departureResponse);
        }

        return $this->getDataJsonResponse($departureResponse->dto);
    }

}
