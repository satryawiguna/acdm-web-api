<?php
namespace App\Service\Contracts\System;


use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\IntegerResponse;
use App\Core\Service\Response\StringResponse;
use App\Service\Contracts\System\Request\CreateAccessRequest;
use App\Service\Contracts\System\Request\CreateGroupRequest;
use App\Service\Contracts\System\Request\CreatePermissionRequest;
use App\Service\Contracts\System\Request\CreateRoleRequest;
use App\Service\Contracts\System\Request\UpdateAccessRequest;
use App\Service\Contracts\System\Request\UpdateGroupRequest;
use App\Service\Contracts\System\Request\UpdatePermissionAccessRequest;
use App\Service\Contracts\System\Request\UpdatePermissionRequest;
use App\Service\Contracts\System\Request\UpdateRolePermissionRequest;
use App\Service\Contracts\System\Request\UpdateRoleRequest;

interface ISystemService
{
    public function getGroups(): GenericCollectionResponse;

    public function getGroupsListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getGroupsPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createGroup(CreateGroupRequest $request): GenericObjectResponse;

    public function showGroup(int $id): GenericObjectResponse;

    public function updateGroup(UpdateGroupRequest $request): GenericObjectResponse;

    public function destroyGroup(int $id): IntegerResponse;

    public function destroyGroups(array $ids): BasicResponse;

    public function getSlugGroup(string $name): GenericObjectResponse;


    public function getRoles(int $groupId = null): GenericCollectionResponse;

    public function getRolesListSearch(ListSearchRequest $request, int $groupId = null): GenericListSearchResponse;

    public function getRolesPageSearch(PageSearchRequest $request, int $groupId = null): GenericPageSearchResponse;

    public function createRole(CreateRoleRequest $request): GenericObjectResponse;

    public function showRole(int $id): GenericObjectResponse;

    public function updateRole(UpdateRoleRequest $request): GenericObjectResponse;

    public function destroyRole(int $id): IntegerResponse;

    public function destroyRoles(array $ids): BasicResponse;

    public function getRolePermissions(int $id): GenericCollectionResponse;

    public function syncRolePermissions(UpdateRolePermissionRequest $request): BasicResponse;

    public function getSlugRole(string $name): GenericObjectResponse;


    public function getPermissions(): GenericCollectionResponse;

    public function getPermissionsListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getPermissionsPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createPermission(CreatePermissionRequest $request): GenericObjectResponse;

    public function showPermission(int $id): GenericObjectResponse;

    public function updatePermission(UpdatePermissionRequest $request): GenericObjectResponse;

    public function destroyPermission(int $id): IntegerResponse;

    public function destroyPermissions(array $ids): BasicResponse;

    public function getPermissionAccesses(int $id): GenericCollectionResponse;

    public function syncPermissionAccesses(UpdatePermissionAccessRequest $request): BasicResponse;

    public function getSlugPermission(string $name): GenericObjectResponse;


    public function getAccesses(): GenericCollectionResponse;

    public function getAccessesListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getAccessesPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function createAccess(CreateAccessRequest $request): GenericObjectResponse;

    public function showAccess(int $id): GenericObjectResponse;

    public function updateAccess(UpdateAccessRequest $request): GenericObjectResponse;

    public function destroyAccess(int $id): IntegerResponse;

    public function destroyAccesses(array $ids): BasicResponse;

    public function getSlugAccess(string $name): GenericObjectResponse;
}
