<?php
namespace App\Presentation\Http\Controllers\Api\Membership;


use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Membership\IMembershipService;
use App\Service\Contracts\Membership\Request\UpdateUserAccessRequest;
use App\Service\Contracts\Membership\Request\UpdateUserGroupRequest;
use App\Service\Contracts\Membership\Request\UpdateUserPermissionRequest;
use App\Service\Contracts\Membership\Request\UpdateUserProfileRequest;
use App\Service\Contracts\Membership\Request\UpdateUserRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiBaseController
{
    private IMembershipService $_membershipService;

    public function __construct(IMembershipService $membershipService)
    {
        $this->_membershipService = $membershipService;
    }

    /**
     * @OA\Get(
     *     path="/membership/users",
     *     operationId="actionGetUsers",
     *     tags={"Membership", "User"},
     *     description="Get users",
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
     *                      @OA\Schema(ref="#/components/schemas/UserEloquent")
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
    public function actionGetUsers()
    {
        $getUsersResponse = $this->_membershipService->getUsers();

        if ($getUsersResponse->isError()) {
            return $this->getErrorJson($getUsersResponse);
        }

        return $this->getDataJsonResponse($getUsersResponse->dtoCollection());
    }

    /**
     * @OA\Get(
     *     path="/membership/users-group-by-role",
     *     operationId="actionGetUsersGroupByRole",
     *     tags={"Membership", "User"},
     *     description="Get users group by role",
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
     *          @OA\JsonContent()
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
    public function actionGetUsersGroupByRole()
    {
        $getUsersResponse = $this->_membershipService->getUsersGroupByRole();

        if ($getUsersResponse->isError()) {
            return $this->getErrorJson($getUsersResponse);
        }

        return $this->getDataJsonResponse($getUsersResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/membership/users/list-search",
     *     operationId="actionUsersListSearch",
     *     tags={"Membership", "User"},
     *     description="Users list search",
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
     *                                  @OA\Schema(ref="#/components/schemas/UserEloquent")
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetUsersListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_membershipService, 'getUsersListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/membership/users/page-search",
     *     operationId="actionUsersPageSearch",
     *     tags={"Membership", "User"},
     *     description="Users page search",
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
     *                                  @OA\Schema(ref="#/components/schemas/UserEloquent")
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
    public function actionGetUsersPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_membershipService, 'getUsersPageSearch']);
    }

    /**
     * @OA\Get(
     *     path="/membership/user/{id}",
     *     operationId="actionShowUser",
     *     tags={"Membership", "User"},
     *     description="Show user",
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
     *                  @OA\Schema(ref="#/components/schemas/UserEloquent")
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
    public function actionShowUser(int $id)
    {
        $showUserResponse = $this->_membershipService->showUser($id);

        if ($showUserResponse->isError()) {
            return $this->getErrorJson($showUserResponse);
        }

        return $this->getDataJsonResponse($showUserResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/membership/user/{id}",
     *     operationId="actionDestroyUser",
     *     tags={"Membership", "User"},
     *     description="Destroy user",
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
    public function actionDestroyUser(int $id)
    {
        $destroyUserResponse = $this->_membershipService->destroyUser($id);

        if ($destroyUserResponse->isError()) {
            return $this->getErrorJson($destroyUserResponse);
        }

        return $this->getBasicSuccessJson($destroyUserResponse);
    }

    /**
     * @OA\Delete(
     *     path="/membership/users",
     *     operationId="actionDestroyUsers",
     *     tags={"Membership", "User"},
     *     description="Destroy users",
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
    public function actionDestroyUsers(Request $request)
    {
        $ids = $request->input('ids');

        $destroyUserResponse = $this->_membershipService->destroyUsers($ids);

        if ($destroyUserResponse->isError()) {
            return $this->getErrorJson($destroyUserResponse);
        }

        return $this->getBasicSuccessJson($destroyUserResponse);
    }


    /**
     * @OA\Get(
     *     path="/membership/user/profile/me",
     *     operationId="actionGetUserProfileMe",
     *     tags={"Membership", "User", "Profile", "Me"},
     *     description="Get user profile me",
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
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/UserEloquent"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="profile",
     *                          allOf={
     *                              @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                              @OA\Schema(ref="#/components/schemas/ProfileEloquent")
     *                          }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetUserProfileMe()
    {
        $getUserProfileResponse = $this->_membershipService->getUserProfile(Auth::id());

        if ($getUserProfileResponse->isError()) {
            return $this->getErrorJson($getUserProfileResponse);
        }

        return $this->getDataJsonResponse($getUserProfileResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/membership/user/profile/me",
     *     operationId="actionUpdateUserProfileMe",
     *     tags={"Membership", "User", "Profile"},
     *     description="Sync user profile",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateUserProfileRequest")
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionUpdateUserProfileMe(Request $request)
    {
        $updateUserProfileRequest = new UpdateUserProfileRequest();
        $updateUserProfileRequest->id = (int)Auth::id();
        $updateUserProfileRequest->email = (string)$request->input('email');
        $updateUserProfileRequest->username = (string)$request->input('username');
        $updateUserProfileRequest->password = (string)$request->input('password');
        $updateUserProfileRequest->password_confirm = (string)$request->input('password_confirm');
        $updateUserProfileRequest->status = (string)$request->input('status');

        $updateUserProfileRequest->profile = (object)$request->input('profile');

        $updateUserProfileRequest->media = (array)$request->input('media');

        $updateUserProfileRequest->roles = (array)$request->input('roles');

        $this->setRequestAuthor($updateUserProfileRequest);

        $updateUserProfileResponse = $this->_membershipService->updateUserProfile($updateUserProfileRequest);

        if ($updateUserProfileResponse->isError()) {
            return $this->getErrorJson($updateUserProfileResponse);
        }

        return $this->getBasicSuccessJson($updateUserProfileResponse);
    }

    /**
     * @OA\Get(
     *     path="/membership/user/profile/{userId}",
     *     operationId="actionGetUserProfile",
     *     tags={"Membership", "User", "Profile"},
     *     description="Get user profile",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          description="User id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
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
     *                  @OA\Schema(ref="#/components/schemas/UserEloquent"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="profile",
     *                          allOf={
     *                              @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                              @OA\Schema(ref="#/components/schemas/ProfileEloquent")
     *                          }
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
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetUserProfile(int $userId)
    {
        $getUserProfileResponse = $this->_membershipService->getUserProfile($userId);

        if ($getUserProfileResponse->isError()) {
            return $this->getErrorJson($getUserProfileResponse);
        }

        return $this->getDataJsonResponse($getUserProfileResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/membership/user/profile/{userId}",
     *     operationId="actionUpdateUserProfile",
     *     tags={"Membership", "User", "Profile"},
     *     description="Sync user profile",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          description="User id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateUserProfileRequest")
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
     * @param int $userId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionUpdateUserProfile(int $userId, Request $request)
    {
        $updateUserProfileRequest = new UpdateUserProfileRequest();
        $updateUserProfileRequest->id = $userId;
        $updateUserProfileRequest->email = (string)$request->input('email') ?? null;
        $updateUserProfileRequest->username = (string)$request->input('username') ?? null;
        $updateUserProfileRequest->password = (string)$request->input('password') ?? null;
        $updateUserProfileRequest->password_confirm = (string)$request->input('password_confirm') ?? null;
        $updateUserProfileRequest->status = (string)$request->input('status') ?? null;

        $updateUserProfileRequest->profile = (object)$request->input('profile') ?? null;

        $updateUserProfileRequest->media = (array)$request->input('media') ?? null;

        $updateUserProfileRequest->roles = (array)$request->input('roles') ?? null;

        $this->setRequestAuthor($updateUserProfileRequest);

        $updateUserProfileResponse = $this->_membershipService->updateUserProfile($updateUserProfileRequest);

        if ($updateUserProfileResponse->isError()) {
            return $this->getErrorJson($updateUserProfileResponse);
        }


        return $this->getBasicSuccessJson($updateUserProfileResponse);
    }


    /**
     * @OA\Get(
     *     path="/membership/user/{id}/group",
     *     operationId="actionGetUserGroup",
     *     tags={"Membership", "User"},
     *     description="Get user group",
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
    public function actionGetUserGroup(int $id)
    {
        $getUserGroupsResponse = $this->_membershipService->getUserGroup($id);

        if ($getUserGroupsResponse->isError()) {
            return $this->getErrorJson($getUserGroupsResponse);
        }

        return $this->getDataJsonResponse($getUserGroupsResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/membership/user/group",
     *     operationId="actionUpdateUserGroup",
     *     tags={"Membership", "User"},
     *     description="Update user group",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateUserGroupRequest")
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
    public function actionUpdateUserGroup(Request $request, int $id)
    {
        $updateUserGroupRequest = new UpdateUserGroupRequest();
        $updateUserGroupRequest->id = (int)$id;
        $updateUserGroupRequest->groups = (array)$request->input('groups');

        $this->setRequestAuthor($updateUserGroupRequest);

        $updateUserGroupResponse = $this->_membershipService->updateUserGroup($updateUserGroupRequest);

        if ($updateUserGroupResponse->isError()) {
            return $this->getErrorJson($updateUserGroupResponse);
        }

        return $this->getBasicSuccessJson($updateUserGroupResponse);
    }


    /**
     * @OA\Get(
     *     path="/membership/user/{id}/roles",
     *     operationId="actionGetUserRoles",
     *     tags={"Membership", "User"},
     *     description="Get user roles",
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
    public function actionGetUserRoles(int $id)
    {
        $getUserRolesResponse = $this->_membershipService->getUserRoles($id);

        if ($getUserRolesResponse->isError()) {
            return $this->getErrorJson($getUserRolesResponse);
        }

        return $this->getDataJsonResponse($getUserRolesResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/membership/user/{id}/roles",
     *     operationId="actionUpdateUserRoles",
     *     tags={"Membership", "User"},
     *     description="Update user roles",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateUserRoleRequest")
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
    public function actionUpdateUserRoles(Request $request, int $id)
    {
        $updateUserRoleRequest = new UpdateUserRoleRequest();
        $updateUserRoleRequest->id = (int)$id;
        $updateUserRoleRequest->roles = (array)$request->input('roles');

        $this->setRequestAuthor($updateUserRoleRequest);

        $updateUserRoleResponse = $this->_membershipService->updateUserRoles($updateUserRoleRequest);

        if ($updateUserRoleResponse->isError()) {
            return $this->getErrorJson($updateUserRoleResponse);
        }

        return $this->getBasicSuccessJson($updateUserRoleResponse);
    }


    /**
     * @OA\Get(
     *     path="/membership/user/{id}/permissions",
     *     operationId="actionGetUserPermissions",
     *     tags={"Membership", "User"},
     *     description="Get user permissions",
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
     *          description="Success"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetUserPermissions(int $id)
    {
        $getUserPermissionsResponse = $this->_membershipService->getUserPermissions($id);

        if ($getUserPermissionsResponse->isError()) {
            return $this->getErrorJson($getUserPermissionsResponse);
        }

        return $this->getDataJsonResponse($getUserPermissionsResponse->dto);
    }

    /**
     * @OA\put(
     *     path="/membership/user/{id}/permissions",
     *     operationId="actionUpdateUserPermissions",
     *     tags={"Membership", "User"},
     *     description="Update user permissions",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateUserPermissionRequest")
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
    public function actionUpdateUserPermissions(Request $request, int $id)
    {
        $updateUserPermissionRequest = new UpdateUserPermissionRequest();
        $updateUserPermissionRequest->id = (int)$id;
        $updateUserPermissionRequest->permissions = (array)$request->input('permissions');

        $this->setRequestAuthor($updateUserPermissionRequest);

        $updateUserPermissionResponse = $this->_membershipService->updateUserPermissions($updateUserPermissionRequest);

        if ($updateUserPermissionResponse->isError()) {
            return $this->getErrorJson($updateUserPermissionResponse);
        }

        return $this->getBasicSuccessJson($updateUserPermissionResponse);
    }


    /**
     * @OA\Get(
     *     path="/membership/user/{id}/permission/{permissionId}/accesses",
     *     operationId="actionGetUseAccesses",
     *     tags={"Membership", "User"},
     *     description="Get user accesses",
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
     *     @OA\Parameter(
     *          name="permissionId",
     *          in="path",
     *          description="Permission id parameter",
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
     *          description="Success"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $id
     * @param int $permissionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetUserAccesses(int $id, int $permissionId)
    {
        $getUserAccessesResponse = $this->_membershipService->getUserAccesses($id, $permissionId);

        if ($getUserAccessesResponse->isError()) {
            return $this->getErrorJson($getUserAccessesResponse);
        }

        return $this->getDataJsonResponse($getUserAccessesResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/membership/user/{id}/permission/{permissionId}/accesses",
     *     operationId="actionPutUserAccesses",
     *     tags={"Membership", "User"},
     *     description="Sync user accesses",
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
     *     @OA\Parameter(
     *          name="permissionId",
     *          in="path",
     *          description="Permission id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateUserAccessRequest")
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
    public function actionUpdateUserAccesses(Request $request, int $id, int $permissionId)
    {
        $updateUserAccessRequest = new UpdateUserAccessRequest();
        $updateUserAccessRequest->id = (int)$id;
        $updateUserAccessRequest->accesses = (array)$request->input('accesses');

        $this->setRequestAuthor($updateUserAccessRequest);

        $updateUserAccessResponse = $this->_membershipService->updateUserAccesses($updateUserAccessRequest);

        if ($updateUserAccessResponse->isError()) {
            return $this->getErrorJson($updateUserAccessResponse);
        }

        return $this->getBasicSuccessJson($updateUserAccessResponse);
    }
}
