<?php

namespace App\Presentation\Http\Controllers\Api\MasterData;

use App\Core\Service\Response\GenericPageSearchResponse;
use App\Http\Controllers\Controller;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\MasterData\IMasterDataService;
use App\Service\Contracts\MasterData\Request\CreateOrganizationRequest;
use App\Service\Contracts\MasterData\Request\UpdateOrganizationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends ApiBaseController
{
    private IMasterDataService $_masterDataService;

    public function __construct(IMasterDataService $masterDataService)
    {
        $this->_masterDataService = $masterDataService;
    }

    /**
     * @OA\Get(
     *     path="/master-data/organizations",
     *     operationId="actionGetOrganizations",
     *     tags={"Master Data", "Organization"},
     *     description="Get organizations",
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
     *              @OA\Items(ref="#/components/schemas/OrganizationEloquent")
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
    public function actionGetOrganizations()
    {
        $getOrganizationsResponse = $this->_masterDataService->getOrganizations();

        if ($getOrganizationsResponse->isError()) {
            return $this->getErrorJson($getOrganizationsResponse);
        }

        return $this->getDataJsonResponse($getOrganizationsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/master-data/organizations/list-search",
     *     operationId="actionOrganizationsListSearch",
     *     tags={"Master Data", "Organization"},
     *     description="Organizations list search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Property(
     *                          property="country_id",
     *                          type="integer",
     *                          format="int64"
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
     *                          @OA\Items(ref="#/components/schemas/OrganizationEloquent")
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
    public function actionGetOrganizationsListSearch(Request $request)
    {
        $countryId = $request->input('country_id');

        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getOrganizationsListSearch'],
            ['countryId' => $countryId]);
    }

    /**
     * @OA\Post(
     *     path="/master-data/organizations/page-search",
     *     operationId="actionOrganizationsPageSearch",
     *     tags={"Master Data", "Organization"},
     *     description="Organizations page search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Property(
     *                          property="country_id",
     *                          type="integer",
     *                          format="int64"
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
     *                          @OA\Items(ref="#/components/schemas/OrganizationEloquent")
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
    public function actionGetOrganizationsPageSearch(Request $request)
    {
        $countryId = $request->input('country_id');

        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getOrganizationsPageSearch'],
            ['countryId' => $countryId]);
    }

    /**
     * @OA\Post(
     *     path="/master-data/organization",
     *     operationId="actionCreateOrganization",
     *     tags={"Master Data", "Organization"},
     *     description="Create organization",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateOrganizationRequest")
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
    public function actionCreateOrganization(Request $request)
    {
        $createOrganizationRequest = new CreateOrganizationRequest();

        $createOrganizationRequest->name = $request->input('name');
        $createOrganizationRequest->slug = $request->input('slug');
        $createOrganizationRequest->country_id = $request->input('country_id');
        $createOrganizationRequest->description = $request->input('description');

        if ($request->input('media')) {
            $createOrganizationRequest->media = (array)$request->input('media');
        }

        if ($request->input('vendors')) {
            $createOrganizationRequest->vendors = (array)$request->input('vendors');
        }

        $this->setRequestAuthor($createOrganizationRequest);

        $createOrganizationResponse = $this->_masterDataService->createOrganization($createOrganizationRequest);

        if ($createOrganizationResponse->isError()) {
            return $this->getErrorJson($createOrganizationResponse);
        }

        return $this->getBasicSuccessWithDataJson($createOrganizationResponse, $createOrganizationResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/master-data/organization/{id}",
     *     operationId="actionShowOrganization",
     *     tags={"Master Data", "Organization"},
     *     description="Show organization",
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
     *              @OA\Schema(ref="#/components/schemas/OrganizationEloquent")
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
    public function actionShowOrganization(int $id)
    {
        $getShowOrganizationResponse = $this->_masterDataService->showOrganization($id);

        if ($getShowOrganizationResponse->isError()) {
            return $this->getErrorJson($getShowOrganizationResponse);
        }

        return $this->getDataJsonResponse($getShowOrganizationResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/master-data/organization/{id}",
     *     operationId="actionUpdateOrganization",
     *     tags={"Master Data", "Organization"},
     *     description="Update organization",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateOrganizationRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/OrganizationEloquent")
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
    public function actionUpdateOrganization(Request $request, int $id)
    {
        $updateOrganizationRequest = new UpdateOrganizationRequest();

        $updateOrganizationRequest->id = $id;
        $updateOrganizationRequest->name = (string)$request->input('name') ?? null;
        $updateOrganizationRequest->slug = (string)$request->input('slug') ?? null;
        $updateOrganizationRequest->country_id = (string)$request->input('country_id') ?? null;
        $updateOrganizationRequest->description = (string)$request->input('description') ?? null;

        if ($request->input('media')) {
            $updateOrganizationRequest->media = (array)$request->input('media');
        }

        if ($request->input('vendors')) {
            $updateOrganizationRequest->vendors = (array)$request->input('vendors');
        }

        $this->setRequestAuthor($updateOrganizationRequest);

        $updateOrganizationResponse = $this->_masterDataService->updateOrganization($updateOrganizationRequest);

        if ($updateOrganizationResponse->isError()) {
            return $this->getErrorJson($updateOrganizationResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateOrganizationResponse, $updateOrganizationResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/master-data/organization/{id}",
     *     operationId="actionDestroyOrganization",
     *     tags={"Master Data", "Organization"},
     *     description="Destroy organization",
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
    public function actionDestroyOrganization(int $id)
    {
        $destroyOrganizationResponse = $this->_masterDataService->destroyOrganization($id);

        if ($destroyOrganizationResponse->isError()) {
            return $this->getErrorJson($destroyOrganizationResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyOrganizationResponse, "Organization deleted: " . $destroyOrganizationResponse->result);
    }

    /**
     * @OA\Get(
     *     path="/master-data/organization/slug/{name}",
     *     operationId="getSlugOrganization",
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
    public function actionGetSlugOrganization(string $name)
    {
        $getSlugOrganizationResponse = $this->_masterDataService->getSlugCountry($name);

        if ($getSlugOrganizationResponse->isError()) {
            return $this->getErrorJson($getSlugOrganizationResponse);
        }

        return $this->getDataJsonResponse($getSlugOrganizationResponse->dto);
    }
}
