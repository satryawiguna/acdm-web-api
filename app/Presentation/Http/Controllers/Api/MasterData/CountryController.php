<?php

namespace App\Presentation\Http\Controllers\Api\MasterData;

use App\Http\Controllers\Controller;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\MasterData\IMasterDataService;
use App\Service\Contracts\MasterData\Request\CreateCountryRequest;
use App\Service\Contracts\MasterData\Request\UpdateCountryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends ApiBaseController
{
    private IMasterDataService $_masterDataService;

    public function __construct(IMasterDataService $masterDataService)
    {
        $this->_masterDataService = $masterDataService;
    }

    /**
     * @OA\Get(
     *     path="/master-data/countries",
     *     operationId="actionGetCountries",
     *     tags={"Master Data", "Country"},
     *     description="Get countries",
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
     *              @OA\Items(ref="#/components/schemas/CountryEloquent")
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
    public function actionGetCountries()
    {
        $getCountriesResponse = $this->_masterDataService->getCountries();

        if ($getCountriesResponse->isError()) {
            return $this->getErrorJson($getCountriesResponse);
        }

        return $this->getDataJsonResponse($getCountriesResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/master-data/countries/list-search",
     *     operationId="actionCountriesListSearch",
     *     tags={"Master Data", "Country"},
     *     description="Countries list search",
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
     *                          @OA\Items(ref="#/components/schemas/CountryEloquent")
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
    public function actionGetCountriesListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getCountriesListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/countries/page-search",
     *     operationId="actionCountriesPageSearch",
     *     tags={"Master Data", "Country"},
     *     description="Countries page search",
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
     *                          @OA\Items(ref="#/components/schemas/CountryEloquent")
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
    public function actionGetCountriesPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getCountriesPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/country",
     *     operationId="actionCreateCountry",
     *     tags={"Master Data", "Country"},
     *     description="Create country",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateCountryRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/CountryEloquent")
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
    public function actionCreateCountry(Request $request)
    {
        $createCountryRequest = new CreateCountryRequest();

        $createCountryRequest->name = (string)$request->input('name') ?? null;
        $createCountryRequest->slug = (string)$request->input('slug') ?? null;
        $createCountryRequest->calling_code = (string)$request->input('calling_code') ?? null;
        $createCountryRequest->iso_code_two_digit = (string)$request->input('iso_code_two_digit') ?? null;
        $createCountryRequest->iso_code_three_digit = (string)$request->input('iso_code_three_digit') ?? null;

        $this->setRequestAuthor($createCountryRequest);

        $createCountryResponse = $this->_masterDataService->createCountry($createCountryRequest);

        if ($createCountryResponse->isError()) {
            return $this->getErrorJson($createCountryResponse);
        }

        return $this->getBasicSuccessWithDataJson($createCountryResponse, $createCountryResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/master-data/country/{id}",
     *     operationId="actionShowCountry",
     *     tags={"Master Data", "Country"},
     *     description="Show country",
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
     *              @OA\Schema(ref="#/components/schemas/CountryEloquent")
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
    public function actionShowCountry(int $id)
    {
        $getShowCountryResponse = $this->_masterDataService->showCountry($id);

        if ($getShowCountryResponse->isError()) {
            return $this->getErrorJson($getShowCountryResponse);
        }

        return $this->getDataJsonResponse($getShowCountryResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/master-data/country/{id}",
     *     operationId="actionUpdateCountry",
     *     tags={"Master Data", "Country"},
     *     description="Update country",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateCountryRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/CountryEloquent")
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
    public function actionUpdateCountry(Request $request, int $id)
    {
        $updateCountryRequest = new UpdateCountryRequest();

        $updateCountryRequest->id = $id;
        $updateCountryRequest->name = (string)$request->input('name') ?? null;
        $updateCountryRequest->slug = (string)$request->input('slug') ?? null;
        $updateCountryRequest->calling_code = (string)$request->input('calling_code') ?? null;
        $updateCountryRequest->iso_code_two_digit = (string)$request->input('iso_code_two_digit') ?? null;
        $updateCountryRequest->iso_code_three_digit = (string)$request->input('iso_code_three_digit') ?? null;

        $this->setRequestAuthor($updateCountryRequest);

        $updateCountryResponse = $this->_masterDataService->updateCountry($updateCountryRequest);

        if ($updateCountryResponse->isError()) {
            return $this->getErrorJson($updateCountryResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateCountryResponse, $updateCountryResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/master-data/country/{id}",
     *     operationId="actionDestroyCountry",
     *     tags={"Master Data", "Country"},
     *     description="Destroy country",
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
    public function actionDestroyCountry(int $id)
    {
        $destroyCountryResponse = $this->_masterDataService->destroyCountry($id);

        if ($destroyCountryResponse->isError()) {
            return $this->getErrorJson($destroyCountryResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyCountryResponse, "Country deleted: " . $destroyCountryResponse->result);
    }

    /**
     * @OA\Get(
     *     path="/master-data/country/slug/{name}",
     *     operationId="getSlugCountry",
     *     tags={"Master Data", "Country"},
     *     description="Return country slug",
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
    public function actionGetSlugCountry(string $name)
    {
        $getSlugCountryResponse = $this->_masterDataService->getSlugCountry($name);

        if ($getSlugCountryResponse->isError()) {
            return $this->getErrorJson($getSlugCountryResponse);
        }

        return $this->getDataJsonResponse($getSlugCountryResponse->dto);
    }
}
