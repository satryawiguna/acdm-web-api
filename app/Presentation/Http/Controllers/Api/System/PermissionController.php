<?php
namespace App\Presentation\Http\Controllers\Api\System;


use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\System\Request\CreatePermissionRequest;
use App\Service\Contracts\System\Request\UpdatePermissionAccessRequest;
use App\Service\Contracts\System\Request\UpdatePermissionRequest;
use App\Service\Contracts\System\ISystemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends ApiBaseController
{
    private ISystemService $_systemService;

    public function __construct(ISystemService $systemService)
    {
        $this->_systemService = $systemService;
    }

    /**
     * @OA\Get(
     *     path="/system/permissions",
     *     operationId="actionGetPermissions",
     *     tags={"System", "Permission"},
     *     description="Get permissions",
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
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                      @OA\Schema(ref="#/components/schemas/PermissionEloquent")
     *                  }
     *              )
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetPermissions()
    {
        $getPermissionsResponse = $this->_systemService->getPermissions();

        if ($getPermissionsResponse->isError()) {
            return $this->getErrorJson($getPermissionsResponse);
        }

        return $this->getDataJsonResponse($getPermissionsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/system/permissions/list-search",
     *     operationId="actionPermissionsListSearch",
     *     tags={"System", "Permission"},
     *     description="Permissions list search",
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
     *                          @OA\Items(
     *                              allOf={
     *                                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                                  @OA\Schema(ref="#/components/schemas/PermissionEloquent")
     *                              }
     *                          )
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
    public function actionGetPermissionsListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_systemService, 'getPermissionsListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/system/permissions/page-search",
     *     operationId="actionPermissionsPageSearch",
     *     tags={"System", "Permission"},
     *     description="Permissions page search",
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
     *                          @OA\Items(
     *                              allOf={
     *                                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                                  @OA\Schema(ref="#/components/schemas/PermissionEloquent")
     *                              }
     *                          )
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
    public function actionGetPermissionsPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_systemService, 'getPermissionsPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/system/permission",
     *     operationId="actionCreatePermission",
     *     tags={"System", "Permission"},
     *     description="Create permission",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreatePermissionRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/PermissionEloquent")
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
    public function actionCreatePermission(Request $request)
    {
        $createPermissionRequest = new CreatePermissionRequest();

        $createPermissionRequest->name = $request->input('name');
        $createPermissionRequest->slug = $request->input('slug');
        $createPermissionRequest->server = $request->input('server');
        $createPermissionRequest->path = $request->input('path');
        $createPermissionRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($createPermissionRequest);

        $createPermissionResponse = $this->_systemService->createPermission($createPermissionRequest);

        if ($createPermissionResponse->isError()) {
            return $this->getErrorJson($createPermissionResponse);
        }

        return $this->getBasicSuccessWithDataJson($createPermissionResponse, $createPermissionResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/System/permission/{id}",
     *     operationId="actionShowPermission",
     *     tags={"System", "Permission"},
     *     description="Show permission",
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
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/PermissionEloquent")
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowPermission(int $id)
    {
        $showPermissionResponse = $this->_systemService->showPermission($id);

        if ($showPermissionResponse->isError()) {
            return $this->getErrorJson($showPermissionResponse);
        }

        return $this->getDataJsonResponse($showPermissionResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/system/permission/{id}",
     *     operationId="actionUpdatePermission",
     *     tags={"System", "Permission"},
     *     description="Update permission",
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
     *              @OA\Schema(ref="#/components/schemas/UpdatePermissionRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/GroupEloquent")
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionUpdatePermission(Request $request, int $id)
    {
        $updatePermissionRequest = new UpdatePermissionRequest();

        $updatePermissionRequest->id = $id;
        $updatePermissionRequest->name = $request->input('name');
        $updatePermissionRequest->slug = $request->input('slug');
        $updatePermissionRequest->server = $request->input('server');
        $updatePermissionRequest->path = $request->input('path');
        $updatePermissionRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($updatePermissionRequest);

        $updatePermissionResponse = $this->_systemService->updatePermission($updatePermissionRequest);

        if ($updatePermissionResponse->isError()) {
            return $this->getErrorJson($updatePermissionResponse);
        }

        return $this->getBasicSuccessWithDataJson($updatePermissionResponse, $updatePermissionResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/system/permission/{id}",
     *     operationId="actionDestroyPermission",
     *     tags={"System", "Permission"},
     *     description="Destroy permission",
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
    public function actionDestroyPermission(int $id)
    {
        $destroyPermissionResponse = $this->_systemService->destroyPermission($id);

        if ($destroyPermissionResponse->isError()) {
            return $this->getErrorJson($destroyPermissionResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyPermissionResponse, "Permission deleted: " . $destroyPermissionResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/system/permissions",
     *     operationId="actionDestroyPermissions",
     *     tags={"System", "Permission"},
     *     description="Destroy permissions",
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
    public function actionDestroyPermissions(Request $request)
    {
        $ids = $request->input('ids');

        $destroyPermissionResponse = $this->_systemService->destroyPermissions($ids);

        if ($destroyPermissionResponse->isError()) {
            return $this->getErrorJson($destroyPermissionResponse);
        }

        return $this->getBasicSuccessJson($destroyPermissionResponse);
    }

    /**
     * @OA\Get(
     *     path="/system/permission/{id}/accesses",
     *     operationId="actionGetPermissionAccesses",
     *     tags={"System", "Permission"},
     *     description="Get permission accesses",
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
     *              format="int32"
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
     *              @OA\Schema(ref="#/components/schemas/PermissionAccessResponse")
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetPermissionAccesses(int $id)
    {
        $getPermissionAccessesResponse = $this->_systemService->getPermissionAccesses($id);

        if ($getPermissionAccessesResponse->isError()) {
            return $this->getErrorJson($getPermissionAccessesResponse);
        }

        return $this->getDataJsonResponse($getPermissionAccessesResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/system/permission/{id}/accesses",
     *     operationId="actionSyncPermissionAccesses",
     *     tags={"System", "Permission"},
     *     description="Sync permission accesses",
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
     *              format="int32"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdatePermissionAccessRequest")
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
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionSyncPermissionAccesses(Request $request, int $id)
    {
        $updatePermissionAccessRequest = new UpdatePermissionAccessRequest();
        $updatePermissionAccessRequest->id = $id;
        $updatePermissionAccessRequest->accesses = $request->input('accesses');

        $this->setRequestAuthor($updatePermissionAccessRequest);

        $updatePermissionAccessResponse = $this->_systemService->syncPermissionAccesses($updatePermissionAccessRequest);

        if ($updatePermissionAccessResponse->isError()) {
            return $this->getErrorJson($updatePermissionAccessResponse);
        }

        return $this->getBasicSuccessJson($updatePermissionAccessResponse);
    }

    /**
     * @OA\Get(
     *     path="/system/permission/slug/{name}",
     *     operationId="getSlugPermission",
     *     tags={"System", "Permission"},
     *     description="Return permission slug",
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
    public function actionGetSlugPermission(string $name)
    {
        $getSlugPermissionResponse = $this->_systemService->getSlugPermission($name);

        if ($getSlugPermissionResponse->isError()) {
            return $this->getErrorJson($getSlugPermissionResponse);
        }

        return $this->getDataJsonResponse($getSlugPermissionResponse->dto);
    }
}
