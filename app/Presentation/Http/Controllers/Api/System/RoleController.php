<?php
namespace App\Presentation\Http\Controllers\Api\System;


use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\System\Request\CreateRoleRequest;
use App\Service\Contracts\System\Request\UpdateRolePermissionRequest;
use App\Service\Contracts\System\Request\UpdateRoleRequest;
use App\Service\Contracts\System\ISystemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends ApiBaseController
{
    private ISystemService $_systemService;

    public function __construct(ISystemService $systemService)
    {
        $this->_systemService = $systemService;
    }

    /**
     * @OA\Get(
     *     path="/system/roles",
     *     operationId="actionGetRoles",
     *     tags={"System", "Role"},
     *     description="Get roles",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="group_id",
     *          in="query",
     *          description="Group id parameter",
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
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/RoleEloquent")
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
    public function actionGetRoles(Request $request)
    {
        $groupId = $request->get('group_id');

        $getRolesResponse = $this->_systemService->getRoles($groupId);

        if ($getRolesResponse->isError()) {
            return $this->getErrorJson($getRolesResponse);
        }

        return $this->getDataJsonResponse($getRolesResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/system/roles/list-search",
     *     operationId="actionRolesListSearch",
     *     tags={"System", "Role"},
     *     description="Roles list search",
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
     *                      @OA\Schema(
     *                          @OA\Property(property="group_id", ref="#/components/schemas/RoleEloquent/properties/group_id")
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
     *                          @OA\Items(
     *                              allOf={
     *                                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                                  @OA\Schema(ref="#/components/schemas/RoleEloquent")
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
    public function actionGetListSearchRoles(Request $request)
    {
        $groupId = $request->input('group_id');

        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            },
            [$this->_systemService, 'getRolesListSearch'],
            [$groupId]);
    }

    /**
     * @OA\Post(
     *     path="/system/roles/page-search",
     *     operationId="actionRolesPageSearch",
     *     tags={"System", "Role"},
     *     description="Roles page search",
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
     *                      @OA\Schema(
     *                          @OA\Property(property="group_id", ref="#/components/schemas/RoleEloquent/properties/group_id")
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
    public function actionGetRolesPageSearch(Request $request)
    {
        $groupId = $request->input('group_id');

        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            },
            [$this->_systemService, 'getRolesPageSearch'],
            [$groupId]);
    }

    /**
     * @OA\Post(
     *     path="/system/role",
     *     operationId="actionCreateRole",
     *     tags={"System", "Role"},
     *     description="Create role",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateRoleRequest")
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
    public function actionCreateRole(Request $request)
    {
        $createRoleRequest = new CreateRoleRequest();

        $createRoleRequest->group_id = $request->input('group_id');
        $createRoleRequest->name = $request->input('name');
        $createRoleRequest->slug = $request->input('slug');
        $createRoleRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($createRoleRequest);

        $createRoleResponse = $this->_systemService->createRole($createRoleRequest);

        if ($createRoleResponse->isError()) {
            return $this->getErrorJson($createRoleResponse);
        }

        return $this->getBasicSuccessWithDataJson($createRoleResponse, $createRoleResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/System/role/{id}",
     *     operationId="actionShowRole",
     *     tags={"System", "Role"},
     *     description="Show role",
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
     *                  @OA\Schema(ref="#/components/schemas/RoleEloquent")
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
    public function actionShowRole(int $id)
    {
        $showRoleResponse = $this->_systemService->showRole($id);

        if ($showRoleResponse->isError()) {
            return $this->getErrorJson($showRoleResponse);
        }

        return $this->getDataJsonResponse($showRoleResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/system/role/{id}",
     *     operationId="actionUpdateRole",
     *     tags={"System", "Role"},
     *     description="Update role",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateRoleRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/RoleEloquent")
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
    public function actionUpdateRole(Request $request, int $id)
    {
        $updateRoleRequest = new UpdateRoleRequest();

        $updateRoleRequest->id = $id;
        $updateRoleRequest->group_id = $request->input('group_id');
        $updateRoleRequest->name = $request->input('name');
        $updateRoleRequest->slug = $request->input('slug');
        $updateRoleRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($updateRoleRequest);

        $updateRoleResponse = $this->_systemService->updateRole($updateRoleRequest);

        if ($updateRoleResponse->isError()) {
            return $this->getErrorJson($updateRoleResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateRoleResponse, $updateRoleResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/system/role/{id}",
     *     operationId="actionDestroyRole",
     *     tags={"System", "Role"},
     *     description="Destroy role",
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
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyRole(int $id)
    {
        $destroyRoleResponse = $this->_systemService->destroyRole($id);

        if ($destroyRoleResponse->isError()) {
            return $this->getErrorJson($destroyRoleResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyRoleResponse, "Role deleted: " . $destroyRoleResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/system/roles",
     *     operationId="actionDestroyRoles",
     *     tags={"System", "Role"},
     *     description="Destroy roles",
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
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyRoles(Request $request)
    {
        $ids = $request->input('ids');

        $destroyRoleResponse = $this->_systemService->destroyRoles($ids);

        if ($destroyRoleResponse->isError()) {
            return $this->getErrorJson($destroyRoleResponse);
        }

        return $this->getBasicSuccessJson($destroyRoleResponse);
    }

    /**
     * @OA\Get(
     *     path="/system/role/{id}/permissions",
     *     operationId="actionGetRolePermissions",
     *     tags={"System", "Role"},
     *     description="Get role permissions",
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
     *              @OA\Schema(ref="#/components/schemas/RolePermissionResponse")
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
    public function actionGetRolePermissions(int $id)
    {
        $getRolePermissionsResponse = $this->_systemService->getRolePermissions($id);

        if ($getRolePermissionsResponse->isError()) {
            return $this->getErrorJson($getRolePermissionsResponse);
        }

        return $this->getDataJsonResponse($getRolePermissionsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/system/role/{id}/permissions",
     *     operationId="actionSyncRolePermissions",
     *     tags={"System", "Role"},
     *     description="Sync role permissions",
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
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="permissions",
     *                      description="Permission ids property",
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
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionSyncRolePermissions(Request $request, int $id)
    {
        $updateRolePermissionRequest = new UpdateRolePermissionRequest();
        $updateRolePermissionRequest->id = $id;
        $updateRolePermissionRequest->permissions = $request->input('permissions');

        $this->setRequestAuthor($updateRolePermissionRequest);

        $updateRolePermissionResponse = $this->_systemService->syncRolePermissions($updateRolePermissionRequest);

        if ($updateRolePermissionResponse->isError()) {
            return $this->getErrorJson($updateRolePermissionResponse);
        }

        return $this->getBasicSuccessJson($updateRolePermissionResponse);
    }

    /**
     * @OA\Get(
     *     path="/system/role/slug/{name}",
     *     operationId="getSlugRole",
     *     tags={"System", "Role"},
     *     description="Return role slug",
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
    public function actionGetSlugRole(string $name)
    {
        $getSlugRoleResponse = $this->_systemService->getSlugRole($name);

        if ($getSlugRoleResponse->isError()) {
            return $this->getErrorJson($getSlugRoleResponse);
        }

        return $this->getDataJsonResponse($getSlugRoleResponse->dto);
    }
}
