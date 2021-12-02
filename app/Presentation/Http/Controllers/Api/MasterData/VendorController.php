<?php

namespace App\Presentation\Http\Controllers\Api\MasterData;

use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\MasterData\IMasterDataService;
use App\Service\Contracts\MasterData\Request\CreateVendorRequest;
use App\Service\Contracts\MasterData\Request\UpdateVendorRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VendorController extends ApiBaseController
{
    private IMasterDataService $_masterDataService;

    public function __construct(IMasterDataService $masterDataService)
    {
        $this->_masterDataService = $masterDataService;
    }

    /**
     * @OA\Get(
     *     path="/master-data/vendors",
     *     operationId="actionGetVendors",
     *     tags={"Master Data", "Vendor"},
     *     description="Get vendors",
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
     *              @OA\Items(ref="#/components/schemas/VendorEloquent")
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
    public function actionGetVendors()
    {
        $getVendorsResponse = $this->_masterDataService->getVendors();

        if ($getVendorsResponse->isError()) {
            return $this->getErrorJson($getVendorsResponse);
        }

        return $this->getDataJsonResponse($getVendorsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/master-data/vendors/page-search",
     *     operationId="actionVendorsPageSearch",
     *     tags={"Master Data", "Vendor"},
     *     description="Vendors page search",
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
     *                          @OA\Items(ref="#/components/schemas/VendorEloquent")
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
    public function actionGetVendorsPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_masterDataService, 'getVendorsPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/master-data/vendor",
     *     operationId="actionCreateVendor",
     *     tags={"Master Data", "Vendor"},
     *     description="Create vendor",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateVendorRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/VendorEloquent")
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
    public function actionCreateVendor(Request $request)
    {
        $createVendorRequest = new CreateVendorRequest();

        $createVendorRequest->role_id = (int)$request->input('role_id');
        $createVendorRequest->name = (string)$request->input('name');
        $createVendorRequest->slug = (string)$request->input('slug');
        $createVendorRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($createVendorRequest);

        $createVendorResponse = $this->_masterDataService->createVendor($createVendorRequest);

        if ($createVendorResponse->isError()) {
            return $this->getErrorJson($createVendorResponse);
        }

        return $this->getBasicSuccessWithDataJson($createVendorResponse, $createVendorResponse->dto);
    }

    /**
     * @OA\Post(
     *     path="/master-data/vendors",
     *     operationId="actionCreateVendors",
     *     tags={"Master Data", "Vendor"},
     *     description="Create vendors",
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
     *                      property="vendors",
     *                      description="Vendors property",
     *                      type="array",
     *                      @OA\Items(ref="#/components/schemas/CreateVendorRequest")
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/VendorEloquent")
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
    public function actionCreateVendors(Request $request)
    {
        $vendors = $request->input('vendors');

        $createVendorRequests = new Collection();

        foreach ($vendors as $vendor) {
            $createVendorRequest = new CreateVendorRequest();

            if (is_array($vendor)) {
                $vendors = (object)$vendors;
            }

            $createVendorRequest->role_id = (int)$vendor->role_id;
            $createVendorRequest->name = (string)$vendor->name;
            $createVendorRequest->slug = (string)$vendor->slug;
            $createVendorRequest->description = (property_exists($vendor, 'description')) ? (string)$vendor->description : null;

            $this->setRequestAuthor($createVendorRequest);

            $createVendorRequests->push($createVendorRequest);
        }

        $createVendorResponses = $this->_masterDataService->createVendors($createVendorRequests);

        if ($createVendorResponses->isError()) {
            return $this->getErrorJson($createVendorResponses);
        }

        return $this->getBasicSuccessWithDataJson($createVendorResponses, $createVendorResponses->dtoCollection());
    }

    /**
     * @OA\Get(
     *     path="/master-data/vendor/{id}",
     *     operationId="actionShowVendor",
     *     tags={"Master Data", "Vendor"},
     *     description="Show vendor",
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
     *              @OA\Schema(ref="#/components/schemas/VendorEloquent")
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
    public function actionShowVendor(int $id)
    {
        $getShowVendorResponse = $this->_masterDataService->showVendor($id);

        if ($getShowVendorResponse->isError()) {
            return $this->getErrorJson($getShowVendorResponse);
        }

        return $this->getDataJsonResponse($getShowVendorResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/master-data/vendor/{id}",
     *     operationId="actionUpdateVendor",
     *     tags={"Master Data", "Vendor"},
     *     description="Update vendor",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateVendorRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/VendorEloquent")
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
    public function actionUpdateVendor(Request $request, int $id)
    {
        $updateVendorRequest = new UpdateVendorRequest();

        $updateVendorRequest->id = $id;
        $updateVendorRequest->role_id = (int)$request->input('role_id');
        $updateVendorRequest->name = (string)$request->input('name');
        $updateVendorRequest->slug = (string)$request->input('slug');
        $updateVendorRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($updateVendorRequest);

        $updateVendorResponse = $this->_masterDataService->updateVendor($updateVendorRequest);

        if ($updateVendorResponse->isError()) {
            return $this->getErrorJson($updateVendorResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateVendorResponse, $updateVendorResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/master-data/vendors",
     *     operationId="actionUpdateVendors",
     *     tags={"Vendor"},
     *     description="Update vendors",
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
     *                  required={"vendors"},
     *                  @OA\Property(
     *                      property="vendors",
     *                      description="Vendors property",
     *                      type="array",
     *                      @OA\Items(ref="#/components/schemas/UpdateVendorRequest")
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/VendorEloquent")
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
    public function actionUpdateVendors(Request $request)
    {
        $vendors = $request->input('vendors');

        $updateVendorRequests = new Collection();

        foreach ($vendors as $vendor) {
            $updateVendorRequest = new UpdateVendorRequest();

            if (is_array($vendor)) {
                $vendor = (object)$vendor;
            }

            $updateVendorRequest->id = (int)$vendor->id;
            $updateVendorRequest->role_id = (int)$vendor->role_id;
            $updateVendorRequest->name = (string)$vendor->name;
            $updateVendorRequest->slug = (string)$vendor->slug;

            $this->setRequestAuthor($updateVendorRequest);

            $updateVendorRequests->push($updateVendorRequests);
        }

        $updateVendorResponse = $this->_masterDataService->updateVendors($updateVendorRequests);

        if ($updateVendorResponse->isError()) {
            return $this->getErrorJson($updateVendorResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateVendorResponse, $updateVendorResponse->dtoCollection());
    }

    /**
     * @OA\Delete(
     *     path="/master-data/vendor/{id}",
     *     operationId="actionDestroyVendor",
     *     tags={"Master Data", "Vendor"},
     *     description="Destroy vendor",
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
    public function actionDestroyVendor(int $id)
    {
        $destroyVendorResponse = $this->_masterDataService->destroyVendor($id);

        if ($destroyVendorResponse->isError()) {
            return $this->getErrorJson($destroyVendorResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyVendorResponse, "Vendor deleted: " . $destroyVendorResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/master-data/vendors",
     *     operationId="actionDestroyVendors",
     *     tags={"Master Data", "Vendor"},
     *     description="Destroy vendors",
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
    public function actionDestroyVendors(Request $request)
    {
        $ids = $request->input('ids');

        $destroyVendorResponse = $this->_masterDataService->destroyVendors($ids);

        if ($destroyVendorResponse->isError()) {
            return $this->getErrorJson($destroyVendorResponse);
        }

        return $this->getBasicSuccessJson($destroyVendorResponse);
    }

    /**
     * @OA\Get(
     *     path="/master-data/vendor/slug/{name}",
     *     operationId="getSlugVendor",
     *     tags={"Master Data", "Vendor"},
     *     description="Return vendor slug",
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
    public function actionGetSlugVendor(string $name)
    {
        $getSlugVendorResponse = $this->_masterDataService->getSlugCountry($name);

        if ($getSlugVendorResponse->isError()) {
            return $this->getErrorJson($getSlugVendorResponse);
        }

        return $this->getDataJsonResponse($getSlugVendorResponse->dto);
    }
}
