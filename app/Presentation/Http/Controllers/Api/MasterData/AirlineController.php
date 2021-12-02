<?php

namespace App\Presentation\Http\Controllers\Api\MasterData;

use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Http\Controllers\Controller;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\MasterData\IMasterDataService;
use App\Service\Contracts\MasterData\Request\CreateAirlineRequest;
use App\Service\Contracts\MasterData\Request\UpdateAirlineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AirlineController extends ApiBaseController
{
    private IMasterDataService $_masterDataService;

    public function __construct(IMasterDataService $masterDataService)
    {
        $this->_masterDataService = $masterDataService;
    }

    /**
     * @OA\Get(
     *     path="/master-data/airlines",
     *     operationId="actionGetAirlines",
     *     tags={"Master Data", "Airline"},
     *     description="Get airlines",
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
     *              @OA\Items(ref="#/components/schemas/AirlineEloquent")
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAirlines()
    {
        $getAirlinesResponse = $this->_masterDataService->getAirlines();

        if ($getAirlinesResponse->isError()) {
            return $this->getErrorJson($getAirlinesResponse);
        }

        return $this->getDataJsonResponse($getAirlinesResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/master-data/airlines/list-search",
     *     operationId="actionAirlinesListSearch",
     *     tags={"Master Data", "Airline"},
     *     description="Airlines list search",
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
     *                          @OA\Items(ref="#/components/schemas/AirlineEloquent")
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
    public function actionGetAirlinesListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getAirlinesListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/airlines/page-search",
     *     operationId="actionAirlinesPageSearch",
     *     tags={"Master Data", "Airline"},
     *     description="Airlines page search",
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
     *                          @OA\Items(ref="#/components/schemas/AirlineEloquent")
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
    public function actionGetAirlinesPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getAirlinesPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/airline",
     *     operationId="actionCreateAirline",
     *     tags={"Master Data", "Airline"},
     *     description="Create airline",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateAirlineRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/AirlineEloquent")
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
    public function actionCreateAirline(Request $request)
    {
        $createAirlineRequest = new CreateAirlineRequest();

        $createAirlineRequest->flight_number = (string)$request->input('flight_number');
        $createAirlineRequest->name = (string)$request->input('name') ?? null;
        $createAirlineRequest->slug = (string)$request->input('slug') ?? null;
        $createAirlineRequest->icao = (string)$request->input('icao') ?? null;
        $createAirlineRequest->iata = (string)$request->input('iata') ?? null;
        $createAirlineRequest->call_sign = (string)$request->input('call_sign') ?? null;

        $this->setRequestAuthor($createAirlineRequest);

        $createAirlineResponse = $this->_masterDataService->createAirline($createAirlineRequest);

        if ($createAirlineResponse->isError()) {
            return $this->getErrorJson($createAirlineResponse);
        }

        return $this->getBasicSuccessWithDataJson($createAirlineResponse, $createAirlineResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/master-data/airline/{id}",
     *     operationId="actionShowAirline",
     *     tags={"Master Data", "Airline"},
     *     description="Show airline",
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
    public function actionShowAirline(int $id)
    {
        $getShowAirlineResponse = $this->_masterDataService->showAirline($id);

        if ($getShowAirlineResponse->isError()) {
            return $this->getErrorJson($getShowAirlineResponse);
        }

        return $this->getDataJsonResponse($getShowAirlineResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/master-data/airline/{id}",
     *     operationId="actionUpdateAirline",
     *     tags={"Master Data", "Airline"},
     *     description="Update airline",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateAirlineRequest")
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
    public function actionUpdateAirline(Request $request, int $id)
    {
        $updateAirlineRequest = new UpdateAirlineRequest();

        $updateAirlineRequest->id = $id;
        $updateAirlineRequest->flight_number = (string)$request->input('flight_number');
        $updateAirlineRequest->name = (string)$request->input('name') ?? null;
        $updateAirlineRequest->slug = (string)$request->input('slug') ?? null;
        $updateAirlineRequest->icao = (string)$request->input('icao') ?? null;
        $updateAirlineRequest->iata = (string)$request->input('iata') ?? null;
        $updateAirlineRequest->call_sign = (string)$request->input('call_sign') ?? null;

        $this->setRequestAuthor($updateAirlineRequest);

        $updateAirlineResponse = $this->_masterDataService->updateAirline($updateAirlineRequest);

        if ($updateAirlineResponse->isError()) {
            return $this->getErrorJson($updateAirlineResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateAirlineResponse, $updateAirlineResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/master-data/airline/{id}",
     *     operationId="actionDestroyAirline",
     *     tags={"Master Data", "Airline"},
     *     description="Destroy airline",
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
    public function actionDestroyAirline(int $id)
    {
        $destroyAirlineResponse = $this->_masterDataService->destroyAirline($id);

        if ($destroyAirlineResponse->isError()) {
            return $this->getErrorJson($destroyAirlineResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyAirlineResponse, "Airline deleted: " . $destroyAirlineResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/master-data/airlines",
     *     operationId="actionDestroyAirlines",
     *     tags={"Master Data", "Airline"},
     *     description="Destroy airlines",
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
    public function actionDestroyAirlines(Request $request)
    {
        $ids = $request->input('ids');

        $destroyAirlineResponse = $this->_masterDataService->destroyAirlines($ids);

        if ($destroyAirlineResponse->isError()) {
            return $this->getErrorJson($destroyAirlineResponse);
        }

        return $this->getBasicSuccessJson($destroyAirlineResponse);
    }

    /**
     * @OA\Get(
     *     path="/master-data/airline/slug/{name}",
     *     operationId="getSlugAirline",
     *     tags={"Master Data", "Airline"},
     *     description="Return airline slug",
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
    public function actionGetSlugAirline(string $name)
    {
        $getSlugAirlineResponse = $this->_masterDataService->getSlugAirline($name);

        if ($getSlugAirlineResponse->isError()) {
            return $this->getErrorJson($getSlugAirlineResponse);
        }

        return $this->getDataJsonResponse($getSlugAirlineResponse->dto);
    }
}
