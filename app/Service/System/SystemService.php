<?php
namespace App\Service\System;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\IntegerResponse;
use App\Domain\Contracts\System\IPermissionRepository;
use App\Domain\Contracts\System\IRoleRepository;
use App\Domain\Contracts\System\IAccessRepository;
use App\Domain\Contracts\System\IGroupRepository;
use App\Domain\System\AccessEloquent;
use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Service\BaseService;
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
use App\Service\Contracts\System\ISystemService;
use Cviebrock\EloquentSluggable\Services\SlugService;

class SystemService extends BaseService implements ISystemService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IGroupRepository $_groupRepository;
    private IRoleRepository $_roleRepository;
    private IPermissionRepository $_permissionRepository;
    private IAccessRepository $_accessRepository;

    public function __construct(IUnitOfWorkFactory $_unitOfWorkFactory,
                                IGroupRepository $groupRepository,
                                IRoleRepository $roleRepository,
                                IPermissionRepository $permissionRepository,
                                IAccessRepository $accessRepository)
    {
        $this->_unitOfWorkFactory = $_unitOfWorkFactory;

        $this->_groupRepository = $groupRepository;
        $this->_roleRepository = $roleRepository;
        $this->_permissionRepository = $permissionRepository;
        $this->_accessRepository = $accessRepository;
    }

    public function getGroups(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_groupRepository, 'all']
        );
    }

    public function getGroupsListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_groupRepository, 'listSearch'],
            $request
        );
    }

    public function getGroupsPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_groupRepository, 'pageSearch'],
            $request
        );
    }

    public function createGroup(CreateGroupRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $group = $this->_groupRepository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description
            ]);

            $this->setAuditableInformationFromRequest($group, $request);

            $rules = [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255'
            ];

            $brokenRules = $group->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $groupResult = $unitOfWork->markNewAndSaveChange($this->_groupRepository, $group);

            $response->dto = $groupResult;
            $response->addInfoMessageResponse('Group created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showGroup(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_groupRepository, 'find'],
            [$id]
        );
    }

    public function updateGroup(UpdateGroupRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $group = $this->_groupRepository->find($request->id);

            if ($group) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $group->fill([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($group, $request);

                $rules = [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255'
                ];

                $brokenRules = $group->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $groupResult = $unitOfWork->markDirtyAndSaveChange($this->_groupRepository, $group);

                $response->dto = $groupResult;
                $response->addInfoMessageResponse('Group updated');

                return $response;
            }

            $response->addErrorMessageResponse('Group not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyGroup(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $group = $this->_groupRepository->find($id);

            if ($group) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $groupResult = $unitOfWork->markRemoveAndSaveChange($this->_groupRepository, $group);

                $response->result = $groupResult;

                return $response;
            }

            $response->addErrorMessageResponse('Group not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyGroups(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $group = $this->_groupRepository->find($id);

                if ($group) {
                    $unitOfWork->markRemove($this->_groupRepository, $group);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Groups deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugGroup(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(GroupEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }



    public function getRoles(int $groupId = null): GenericCollectionResponse
    {
        return $this->search(
            [$this->_roleRepository, 'findRoles'],
            ['groupId' => $groupId]
        );
    }

    public function getRolesListSearch(ListSearchRequest $request, int $groupId = null): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_roleRepository, 'findRolesListSearch'],
            $request,
            [$groupId]
        );
    }

    public function getRolesPageSearch(PageSearchRequest $request, int $groupId = null): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_roleRepository, 'findRolesPageSearch'],
            $request,
            [$groupId]
        );
    }

    public function createRole(CreateRoleRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $role = $this->_roleRepository->newInstance([
                "group_id" => $request->group_id,
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description
            ]);

            $this->setAuditableInformationFromRequest($role, $request);

            $rules = [
                'group_id' => 'required|int',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255'
            ];

            $brokenRules = $role->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $roleResult = $unitOfWork->markNewAndSaveChange($this->_roleRepository, $role);

            $response->dto = $roleResult;
            $response->addInfoMessageResponse('Role created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showRole(int $id): GenericObjectResponse
    {
        return $this->read([$this->_roleRepository, 'find'],
            [$id]);
    }

    public function updateRole(UpdateRoleRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $role = $this->_roleRepository->find($request->id);

            if ($role) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $role->fill([
                    "group_id" => $request->group_id,
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($role, $request);

                $rules = [
                    'group_id' => 'required|int',
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255'
                ];

                $brokenRules = $role->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $roleResult = $unitOfWork->markDirtyAndSaveChange($this->_roleRepository, $role);

                $response->dto = $roleResult;
                $response->addInfoMessageResponse('Role updated');

                return $response;
            }

            $response->addErrorMessageResponse('Role not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyRole(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $role = $this->_roleRepository->find($id);

            if ($role) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $roleResult = $unitOfWork->markRemoveAndSaveChange($this->_roleRepository, $role);

                $response->result = $roleResult;

                return $response;
            }

            $response->addErrorMessageResponse('Role not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyRoles(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $role = $this->_roleRepository->find($id);

                if ($role) {
                    $unitOfWork->markRemove($this->_roleRepository, $role);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Roles deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getRolePermissions(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $response = $this->search([$this->_roleRepository, 'findRolePermissions'],
                [$id]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function syncRolePermissions(UpdateRolePermissionRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $role = $this->_roleRepository->find($request->id);

            if ($role) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $this->setAuditableInformationFromRequest($role, $request);

                if ($request->permissions) {
                    $relations["permissions"] = [
                        "data" => $request->permissions,
                        "method" => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_roleRepository, $role, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('Permissions updated');
            }

            $response->addErrorMessageResponse('Role not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugRole(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(RoleEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getPermissions(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_permissionRepository, 'findPermissions']
        );
    }

    public function getPermissionsListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch([$this->_permissionRepository, 'findPermissionsSearch'],
            $request);
    }

    public function getPermissionsPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch([$this->_permissionRepository, 'findPermissionsPageSearch'],
            $request);
    }

    public function createPermission(CreatePermissionRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $permission = $this->_permissionRepository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "server" => $request->server,
                "path" => $request->path,
                "description" => $request->description
            ]);

            $this->setAuditableInformationFromRequest($permission, $request);

            $rules = [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'server' => 'required|string|max:255',
                'path' => 'required|string|max:255',
            ];

            $brokenRules = $permission->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $permissionResult = $unitOfWork->markNewAndSaveChange($this->_permissionRepository, $permission);

            $response->dto = $permissionResult;
            $response->addInfoMessageResponse('Permission created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showPermission(int $id): GenericObjectResponse
    {
        return $this->read([$this->_permissionRepository, 'find'],
            [$id]);
    }

    public function updatePermission(UpdatePermissionRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $permission = $this->_permissionRepository->find($request->id);

            if ($permission) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $permission->fill([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "server" => $request->server,
                    "path" => $request->path,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($permission, $request);

                $rules = [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255',
                    'server' => 'required|string|max:255',
                    'path' => 'required|string|max:255',
                ];

                $brokenRules = $permission->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $permissionResult = $unitOfWork->markDirtyAndSaveChange($this->_permissionRepository, $permission);

                $response->dto = $permissionResult;
                $response->addInfoMessageResponse('Permission updated');

                return $response;
            }

            $response->addErrorMessageResponse('Permission not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyPermission(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $permission = $this->_permissionRepository->find($id);

            if ($permission) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $permissionResult = $unitOfWork->markRemoveAndSaveChange($this->_permissionRepository, $permission);

                $response->result = $permissionResult;

                return $response;
            }

            $response->addErrorMessageResponse('Permission not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyPermissions(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $permission = $this->_permissionRepository->find($id);

                if ($permission) {
                    $unitOfWork->markRemove($this->_permissionRepository, $permission);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Permissions deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getPermissionAccesses(int $id): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $response = $this->search([$this->_permissionRepository, 'findPermissionAccesses'],
                [$id]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function syncPermissionAccesses(UpdatePermissionAccessRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $permission = $this->_permissionRepository->find($request->id);

            if ($permission) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $this->setAuditableInformationFromRequest($permission, $request);

                if ($request->accesses) {
                    $relations["accesses"] = [
                        "data" => $request->accesses,
                        "method" => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_roleRepository, $permission, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('Access updated');
            }

            $response->addErrorMessageResponse('Permission not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugPermission(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(PermissionEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }



    public function getAccesses(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_accessRepository, 'all']
        );
    }

    public function getAccessesListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_accessRepository, 'listSearch'],
            $request
        );
    }

    public function getAccessesPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_accessRepository, 'pageSearch'],
            $request
        );
    }

    public function createAccess(CreateAccessRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $access = $this->_accessRepository->newInstance([
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description
            ]);

            $this->setAuditableInformationFromRequest($access, $request);

            $rules = [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255'
            ];

            $brokenRules = $access->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $accessResult = $unitOfWork->markNewAndSaveChange($this->_accessRepository, $access);

            $response->dto = $accessResult;
            $response->addInfoMessageResponse('Access created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showAccess(int $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_accessRepository, 'find'],
            [$id]
        );
    }

    public function updateAccess(UpdateAccessRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $access = $this->_accessRepository->find($request->id);

            if ($access) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $access->fill([
                    "name" => $request->name,
                    "slug" => $request->slug,
                    "description" => $request->description
                ]);

                $this->setAuditableInformationFromRequest($access, $request);

                $rules = [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255'
                ];

                $brokenRules = $access->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $accessResult = $unitOfWork->markDirtyAndSaveChange($this->_accessRepository, $access);

                $response->dto = $accessResult;
                $response->addInfoMessageResponse('Access updated');

                return $response;
            }

            $response->addErrorMessageResponse('Access not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyAccess(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $access = $this->_accessRepository->find($id);

            if ($access) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $accessResult = $unitOfWork->markRemoveAndSaveChange($this->_accessRepository, $access);

                $response->result = $accessResult;

                return $response;
            }

            $response->addErrorMessageResponse('Access not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyAccesses(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $access = $this->_accessRepository->find($id);

                if ($access) {
                    $unitOfWork->markRemove($this->_accessRepository, $access);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Accesses deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getSlugAccess(string $name): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $result = (object) [
                'slug' => SlugService::createSlug(AccessEloquent::class, 'slug', $name)
            ];

            $response->dto = $result;
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
