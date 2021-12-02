<?php
namespace App\Service\Contracts\Membership;


use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\IntegerResponse;
use App\Service\Contracts\Membership\Request\UpdateUserAccessRequest;
use App\Service\Contracts\Membership\Request\UpdateUserGroupRequest;
use App\Service\Contracts\Membership\Request\UpdateUserPermissionRequest;
use App\Service\Contracts\Membership\Request\UpdateUserProfileRequest;
use App\Service\Contracts\Membership\Request\UpdateUserRoleRequest;
use App\Service\Contracts\Membership\Request\RegisterUserRequest;

interface IMembershipService
{
    public function registerUser(RegisterUserRequest $request): GenericObjectResponse;


    public function getUsers(): GenericCollectionResponse;

    public function getUsersGroupByRole(): GenericCollectionResponse;

    public function getUsersListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getUsersPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function showUser(int $id): GenericObjectResponse;

    public function destroyUser(int $id): IntegerResponse;

    public function destroyUsers(array $ids): BasicResponse;

    public function getUserProfile(int $id): GenericObjectResponse;

    public function updateUserProfile(UpdateUserProfileRequest $request): BasicResponse;

    public function getUserGroup(int $id): GenericObjectResponse;

    public function updateUserGroup(UpdateUserGroupRequest $request): BasicResponse;

    public function getUserRoles(int $id): GenericObjectResponse;

    public function updateUserRoles(UpdateUserRoleRequest $request): BasicResponse;

    public function getUserPermissions(int $id): GenericObjectResponse;

    public function updateUserPermissions(UpdateUserPermissionRequest $request): BasicResponse;

    public function getUserAccesses(int $id, int $permissionId): GenericObjectResponse;

    public function updateUserAccesses(UpdateUserAccessRequest $request): BasicResponse;

}
