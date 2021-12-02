<?php
namespace App\Presentation\Http\Controllers\Api\System;


use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\System\Request\CreateGroupRequest;
use App\Service\Contracts\System\Request\UpdateGroupRequest;
use App\Service\Contracts\System\ISystemService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GroupController extends ApiBaseController
{
    private ISystemService $_systemService;

    public function __construct(ISystemService $systemService)
    {
        $this->_systemService = $systemService;
    }

    /**
     * @OA\Get(
     *     path="/system/groups",
     *     operationId="actionGetGroups",
     *     tags={"System", "Group"},
     *     description="Get groups",
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
     *                      @OA\Schema(ref="#/components/schemas/GroupEloquent")
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetGroups()
    {
        $getGroupsResponse = $this->_systemService->getGroups();

        if ($getGroupsResponse->isError()) {
            return $this->getErrorJson($getGroupsResponse);
        }

        return $this->getDataJsonResponse($getGroupsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/system/groups/list-search",
     *     operationId="actionGroupsListSearch",
     *     tags={"System", "Group"},
     *     description="Groups list search",
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
     *                                  @OA\Schema(ref="#/components/schemas/GroupEloquent")
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
    public function actionGetGroupsListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_systemService, 'getGroupsListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/system/groups/page-search",
     *     operationId="actionGroupsPageSearch",
     *     tags={"System", "Group"},
     *     description="Groups page search",
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
     *                                  @OA\Schema(ref="#/components/schemas/GroupEloquent")
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
    public function actionGetGroupsPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_systemService, 'getGroupsPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/system/group",
     *     operationId="actionCreateGroup",
     *     tags={"System", "Group"},
     *     description="Create group",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateGroupRequest")
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionCreateGroup(Request $request)
    {
        $createGroupRequest = new CreateGroupRequest();

        $createGroupRequest->name = $request->input('name');
        $createGroupRequest->slug = $request->input('slug');
        $createGroupRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($createGroupRequest);

        $createGroupResponse = $this->_systemService->createGroup($createGroupRequest);

        if ($createGroupResponse->isError()) {
            return $this->getErrorJson($createGroupResponse);
        }

        return $this->getBasicSuccessWithDataJson($createGroupResponse, $createGroupResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/system/group/{id}",
     *     operationId="actionShowGroup",
     *     tags={"System", "Group"},
     *     description="Show group",
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowGroup(int $id)
    {
        $showGroupResponse = $this->_systemService->showGroup($id);

        if ($showGroupResponse->isError()) {
            return $this->getErrorJson($showGroupResponse);
        }

        return $this->getDataJsonResponse($showGroupResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/system/group/{id}",
     *     operationId="actionUpdateGroup",
     *     tags={"System", "Group"},
     *     description="Update group",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateGroupRequest")
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
    public function actionUpdateGroup(Request $request, int $id)
    {
        $updateGroupRequest = new UpdateGroupRequest();

        $updateGroupRequest->id = $id;
        $updateGroupRequest->name = $request->input('name');
        $updateGroupRequest->slug = $request->input('slug');
        $updateGroupRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($updateGroupRequest);

        $updateGroupResponse = $this->_systemService->updateGroup($updateGroupRequest);

        if ($updateGroupResponse->isError()) {
            return $this->getErrorJson($updateGroupResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateGroupResponse, $updateGroupResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/system/group/{id}",
     *     operationId="actionDestroyGroup",
     *     tags={"System", "Group"},
     *     description="Destroy group",
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
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyGroup(int $id)
    {
        $destroyGroupResponse = $this->_systemService->destroyGroup($id);

        if ($destroyGroupResponse->isError()) {
            return $this->getErrorJson($destroyGroupResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyGroupResponse, "Group deleted: " . $destroyGroupResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/system/groups",
     *     operationId="actionDestroyGroups",
     *     tags={"System", "Group"},
     *     description="Destroy groups",
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyGroups(Request $request)
    {
        $ids = $request->input('ids');

        $destroyGroupResponse = $this->_systemService->destroyGroups($ids);

        if ($destroyGroupResponse->isError()) {
            return $this->getErrorJson($destroyGroupResponse);
        }

        return $this->getBasicSuccessJson($destroyGroupResponse);
    }

    /**
     * @OA\Get(
     *     path="/system/group/slug/{name}",
     *     operationId="getSlugGroup",
     *     tags={"System", "Group"},
     *     description="Return group slug",
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
    public function actionGetSlugGroup(string $name)
    {
        $getSlugGroupResponse = $this->_systemService->getSlugGroup($name);

        if ($getSlugGroupResponse->isError()) {
            return $this->getErrorJson($getSlugGroupResponse);
        }

        return $this->getDataJsonResponse($getSlugGroupResponse->dto);
    }
}
