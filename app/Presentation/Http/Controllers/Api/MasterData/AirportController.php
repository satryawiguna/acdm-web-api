<?php
namespace App\Presentation\Http\Controllers\Api\MasterData;


use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\MasterData\IMasterDataService;
use App\Service\Contracts\MasterData\Request\CreateAirportRequest;
use App\Service\Contracts\MasterData\Request\UpdateAirportRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AirportController extends ApiBaseController
{
    private IMasterDataService $_masterDataService;

    public function __construct(IMasterDataService $masterDataService)
    {
        $this->_masterDataService = $masterDataService;
    }

    /**
     * @OA\Get(
     *     path="/master-data/airports",
     *     operationId="actionGetAirports",
     *     tags={"Master Data", "Airport"},
     *     description="Get airports",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/AirportEloquent")
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAirports()
    {
        $getAirportsResponse = $this->_masterDataService->getAirports();

        if ($getAirportsResponse->isError()) {
            return $this->getErrorJson($getAirportsResponse);
        }

        return $this->getDataJsonResponse($getAirportsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/master-data/airports/list-search",
     *     operationId="actionAirportsListSearch",
     *     tags={"Master Data", "Airport"},
     *     description="Airports list search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ListSearchParameter")
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
     *                          @OA\Items(ref="#/components/schemas/AirportEloquent")
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAirportsListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getAirportsListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/airports/page-search",
     *     operationId="actionAirportsPageSearch",
     *     tags={"Master Data", "Airport"},
     *     description="Airports page search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/PageSearchParameter")
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
     *                          @OA\Items(ref="#/components/schemas/AirportEloquent")
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAirportsPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getAirportsPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/airport",
     *     operationId="actionCreateAirport",
     *     tags={"Master Data", "Airport"},
     *     description="Create airport",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateAirportRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/AirportEloquent")
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionCreateAirport(Request $request)
    {
        $createAirportRequest = new CreateAirportRequest();

        $createAirportRequest->name = (string)$request->input('name') ?? null;
        $createAirportRequest->slug = (string)$request->input('slug') ?? null;
        $createAirportRequest->location = (string)$request->input('location') ?? null;
        $createAirportRequest->country = (string)$request->input('country') ?? null;
        $createAirportRequest->icao = (string)$request->input('icao') ?? null;
        $createAirportRequest->iata = (string)$request->input('iata') ?? null;

        $this->setRequestAuthor($createAirportRequest);

        $createAirportResponse = $this->_masterDataService->createAirport($createAirportRequest);

        if ($createAirportResponse->isError()) {
            return $this->getErrorJson($createAirportResponse);
        }

        return $this->getBasicSuccessWithDataJson($createAirportResponse, $createAirportResponse->dto);
    }

    /**
     * @OA\Post(
     *     path="/master-data/airports",
     *     operationId="actionCreateAirports",
     *     tags={"Master Data", "Airport"},
     *     description="Create airports",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="airports",
     *                      description="Airports property",
     *                      type="array",
     *                      @OA\Items(ref="#/components/schemas/CreateAirportRequest")
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/AirportEloquent")
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionCreateAirports(Request $request)
    {
        $airports = $request->input('airports');

        $createAirportRequests = new Collection();

        foreach ($airports as $airport) {
            $createAirportRequest = new CreateAirportRequest();

            if (is_array($airport)) {
                $airport = (object)$airport;
            }

            $createAirportRequest->name = (property_exists($airport, 'name')) ? (string)$airport->name : null;
            $createAirportRequest->slug = (property_exists($airport, 'slug')) ? (string)$airport->slug : null;
            $createAirportRequest->location = (property_exists($airport, 'location')) ? (string)$airport->location : null;
            $createAirportRequest->country = (property_exists($airport, 'country')) ? (string)$airport->country : null;
            $createAirportRequest->icao = (property_exists($airport, 'icao')) ? (string)$airport->icao : null;
            $createAirportRequest->iata = (property_exists($airport, 'iata')) ? (string)$airport->iata : null;

            $this->setRequestAuthor($createAirportRequest);

            $createAirportRequests->push($createAirportRequest);
        }

        $createAirportResponses = $this->_masterDataService->createAirports($createAirportRequests);

        if ($createAirportResponses->isError()) {
            return $this->getErrorJson($createAirportResponses);
        }

        return $this->getBasicSuccessWithDataJson($createAirportResponses, $createAirportResponses->dtoCollection());
    }

    /**
     * @OA\Get(
     *     path="/master-data/airport/{id}",
     *     operationId="actionShowAirport",
     *     tags={"Master Data", "Airport"},
     *     description="Show airport",
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
     *              @OA\Schema(ref="#/components/schemas/AirportEloquent")
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
    public function actionShowAirport(int $id)
    {
        $getShowAirportResponse = $this->_masterDataService->showAirport($id);

        if ($getShowAirportResponse->isError()) {
            return $this->getErrorJson($getShowAirportResponse);
        }

        return $this->getDataJsonResponse($getShowAirportResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/master-data/airport/iata/{code}",
     *     operationId="actionShowAirportByIata",
     *     tags={"Master Data", "Airport"},
     *     description="Show airport by iata",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="code",
     *          in="path",
     *          description="Code parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
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
     *              @OA\Schema(ref="#/components/schemas/AirportEloquent")
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
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowAirportByIata(string $code)
    {
        $getShowAirportByIataResponse = $this->_masterDataService->showAirportByIata($code);

        if ($getShowAirportByIataResponse->isError()) {
            return $this->getErrorJson($getShowAirportByIataResponse);
        }

        return $this->getDataJsonResponse($getShowAirportByIataResponse->dtoCollection()->first());
    }

    /**
     * @OA\Get(
     *     path="/master-data/airport/icao/{code}",
     *     operationId="actionShowAirportByIcao",
     *     tags={"Master Data", "Airport"},
     *     description="Show airport by icao",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="code",
     *          in="path",
     *          description="Code parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
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
     *              @OA\Schema(ref="#/components/schemas/AirportEloquent")
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
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowAirportByIcao(string $code)
    {
        $getShowAirportByIcaoResponse = $this->_masterDataService->showAirportByIcao($code);

        if ($getShowAirportByIcaoResponse->isError()) {
            return $this->getErrorJson($getShowAirportByIcaoResponse);
        }

        return $this->getDataJsonResponse($getShowAirportByIcaoResponse->dtoCollection()->first());
    }

    /**
     * @OA\Put(
     *     path="/master-data/airport/{id}",
     *     operationId="actionUpdateAirport",
     *     tags={"Master Data", "Airport"},
     *     description="Update airport",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateAirportRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/AirportEloquent")
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
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionUpdateAirport(Request $request, int $id)
    {
        $updateAirportRequest = new UpdateAirportRequest();

        $updateAirportRequest->id = $id;
        $updateAirportRequest->name = (string)$request->input('name') ?? null;
        $updateAirportRequest->slug = (string)$request->input('slug') ?? null;
        $updateAirportRequest->location = (string)$request->input('location') ?? null;
        $updateAirportRequest->country = (string)$request->input('country') ?? null;
        $updateAirportRequest->icao = (string)$request->input('icao') ?? null;
        $updateAirportRequest->iata = (string)$request->input('iata') ?? null;

        $this->setRequestAuthor($updateAirportRequest);

        $updateAirportResponse = $this->_masterDataService->updateAirport($updateAirportRequest);

        if ($updateAirportResponse->isError()) {
            return $this->getErrorJson($updateAirportResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateAirportResponse, $updateAirportResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/master-data/airports",
     *     operationId="actionUpdateAirports",
     *     tags={"Airport"},
     *     description="Update airports",
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
     *                  required={"airports"},
     *                  @OA\Property(
     *                      property="airports",
     *                      description="Airports property",
     *                      type="array",
     *                      @OA\Items(ref="#/components/schemas/UpdateAirportRequest")
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/AirportEloquent")
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionUpdateAirports(Request $request)
    {
        $airports = $request->input('airports');

        $updateAirportRequests = new Collection();

        foreach ($airports as $airport) {
            $updateAirportRequest = new UpdateAirportRequest();

            if (is_array($airport)) {
                $airport = (object)$airport;
            }

            $updateAirportRequest->id = (int)$airport->id;
            $updateAirportRequest->name = (property_exists($airport, 'name')) ? (string)$airport->name : null;
            $updateAirportRequest->slug = (property_exists($airport, 'slug')) ? (string)$airport->slug : null;
            $updateAirportRequest->location = (property_exists($airport, 'location')) ? (string)$airport->location : null;
            $updateAirportRequest->country = (property_exists($airport, 'country')) ? (string)$airport->country : null;
            $updateAirportRequest->iata = (property_exists($airport, 'iata')) ? (string)$airport->iata : null;
            $updateAirportRequest->icao = (property_exists($airport, 'icao')) ? (string)$airport->icao : null;

            $this->setRequestAuthor($updateAirportRequest);

            $updateAirportRequests->push($updateAirportRequest);
        }

        $updateAirportResponse = $this->_masterDataService->updateAirports($updateAirportRequests);

        if ($updateAirportResponse->isError()) {
            return $this->getErrorJson($updateAirportResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateAirportResponse, $updateAirportResponse->dtoCollection());
    }

    /**
     * @OA\Delete(
     *     path="/master-data/airport/{id}",
     *     operationId="actionDestroyAirport",
     *     tags={"Master Data", "Airport"},
     *     description="Destroy airport",
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
     *              mediaType="application/json"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success"
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
    public function actionDestroyAirport(int $id)
    {
        $destroyAirportResponse = $this->_masterDataService->destroyAirport($id);

        if ($destroyAirportResponse->isError()) {
            return $this->getErrorJson($destroyAirportResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyAirportResponse, "Airport deleted: " . $destroyAirportResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/master-data/airports",
     *     operationId="actionDestroyAirports",
     *     tags={"Master Data", "Airport"},
     *     description="Destroy airports",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
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
     *                          format="int64"
     *                      ),
     *                      example={1,2,3}
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyAirports(Request $request)
    {
        $ids = $request->input('ids');

        $destroyAirportResponse = $this->_masterDataService->destroyAirports($ids);

        if ($destroyAirportResponse->isError()) {
            return $this->getErrorJson($destroyAirportResponse);
        }

        return $this->getBasicSuccessJson($destroyAirportResponse);
    }

    /**
     * @OA\Get(
     *     path="/master-data/airport/slug/{name}",
     *     operationId="getSlugAirport",
     *     tags={"Master Data", "Airport"},
     *     description="Return airport slug",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
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
     * @param string $name
     * @return JsonResponse
     */
    public function actionGetSlugAirport(string $name)
    {
        $getSlugAirportResponse = $this->_masterDataService->getSlugAirport($name);

        if ($getSlugAirportResponse->isError()) {
            return $this->getErrorJson($getSlugAirportResponse);
        }

        return $this->getDataJsonResponse($getSlugAirportResponse->dto);
    }
}
