<?php
namespace App\Service\Membership;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\IntegerResponse;
use App\Domain\Contracts\Membership\IProfileRepository;
use App\Domain\Contracts\Membership\IUserRepository;
use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Service\BaseService;
use App\Service\Contracts\Membership\IMembershipService;
use App\Service\Contracts\Membership\Request\UpdateUserAccessRequest;
use App\Service\Contracts\Membership\Request\UpdateUserGroupRequest;
use App\Service\Contracts\Membership\Request\UpdateUserPermissionRequest;
use App\Service\Contracts\Membership\Request\UpdateUserProfileRequest;
use App\Service\Contracts\Membership\Request\UpdateUserRoleRequest;
use App\Service\Contracts\Membership\Request\RegisterUserRequest;
use Illuminate\Validation\Rule;

class MembershipService extends BaseService implements IMembershipService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IUserRepository $_userRepository;
    private IProfileRepository $_profileRepository;

    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IUserRepository $userRepository,
                                IProfileRepository $profileRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;

        $this->_userRepository = $userRepository;
        $this->_profileRepository = $profileRepository;
    }

    public function registerUser(RegisterUserRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $user = $this->_userRepository->newInstance([
                "email" => $request->email,
                "username" => $request->username,
                "password" => $request->password,
                "status" => $request->status
            ]);

            $this->setAuditableInformationFromRequest($user, $request);

            $rules = [
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8',
                'password_confirm' => 'required|same:password',
                'status' => 'required'
            ];

            $brokenRules = $user->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $profile = $this->_profileRepository->newInstance([
                "full_name" => $request->full_name,
                "nick_name" => $request->nick_name,
                "email" => $request->email
            ]);

            $this->setAuditableInformationFromRequest($profile, $request);

            $rules = [
                'full_name' => 'required|string|max:255',
                'nick_name' => 'string',
                'email' => 'required|string|email|max:255'
            ];

            $brokenRules = $profile->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            if ($request->groups) {
                $relations["groups"] = [
                    "data" => $request->groups,
                    "method" => RelationMethodType::ATTACH()
                ];
            }

            if ($request->roles) {
                $relations["roles"] = [
                    "data" => $request->roles,
                    "method" => RelationMethodType::ATTACH()
                ];
            }

            if ($request->vendors) {
                $relations["vendors"] = [
                    "data" => $request->vendors,
                    "method" => RelationMethodType::ATTACH()
                ];
            }

            $user->setAttribute('password', bcrypt($request->password));
            $userResult = $unitOfWork->markNewAndSaveChange($this->_userRepository, $user, $relations);

            $profile->setAttribute('profileable_id', $userResult->id);
            $profile->setAttribute('profileable_type', 'users');

            $unitOfWork->markNew($this->_profileRepository, $profile);
            $unitOfWork->commit();

            $response->dto = $userResult;
            $response->addInfoMessageResponse('User created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getUsers(): GenericCollectionResponse
    {
        return $this->search([$this->_userRepository, 'findUsers']);
    }

    public function getUsersGroupByRole(): GenericCollectionResponse
    {
        return $this->search([$this->_userRepository, 'findUserProfilesGroupByRole']);
    }

    public function getUsersListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch([$this->_userRepository, 'findUsersListSearch'],
            $request);
    }

    public function getUsersPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch([$this->_userRepository, 'findUsersPageSearch'],
            $request);
    }

    public function showUser(int $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $response = $this->read([$this->_userRepository, 'find'],
                [$id]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyUser(int $id): IntegerResponse
    {
        $response = new IntegerResponse();

        try {
            $user = $this->_userRepository->find($id);

            if ($user) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $userResult = $unitOfWork->markRemoveAndSaveChange($this->_userRepository, $user);

                $response->result = $userResult;

                return $response;
            }

            $response->addErrorMessageResponse('User not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyUsers(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $user = $this->_userRepository->find($id);

                if ($user) {
                    $unitOfWork->markRemove($this->_userRepository, $user);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Users deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getUserProfile(int $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
//            $response = $this->read([$this->_userRepository, 'findUserProfile'],
//                [$id]);

            $profile = $this->_userRepository->findUserProfile($id);

            foreach ($profile->roles as $role) {
                foreach ($role->permissions as $permission) {
                    $userPermission = $this->_userRepository->findUserPermission($profile->profileable_id, $permission->id);

                    if ($userPermission->permissions->count() > 0) {
                        $permission->value = $userPermission->permissions->first()->value;
                    }

                    foreach ($permission->accesses as $access) {
                        $userAccess = $this->_userRepository->findUserAccess($profile->profileable_id, $permission->id, $access->id);

                        if ($userAccess->accesses->count() > 0) {
                            $access->value = $userAccess->accesses->first()->value;
                        }
                    }
                }
            }

            $response->dto = $profile;
            $response->addInfoMessageResponse('Profile me success');

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateUserProfile(UpdateUserProfileRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->_userRepository->find($request->id);

            if ($user) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $rules = [
                    'email' => [
                        'required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id
                    ],
                    'username' => [
                        'required', 'string', 'max:255', 'unique:users,username,' . $request->id
                    ],
                    'status' => 'required'
                ];

                $items = [
                    'email' => $request->email = $request->email ?: $user->email,
                    'username' => $request->username = $request->username ?: $user->username,
                    'status' => $request->status = $request->status ?: $user->status
                ];

                if ($request->password) {
                    $items['password'] = bcrypt($request->password);

                    $rules['password'] = 'required|string|min:8';
                    $rules['password_confirm'] = 'same:password';
                }

                $user->fill($items);

                $this->setAuditableInformationFromRequest($user, $request);

                $brokenRules = $user->validate($rules, $request);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                $relations = [];

                if ($request->profile) {
                    $profile = $this->_userRepository->findUserProfile($request->id);

                    $rules = [
                        'full_name' => 'required|string|max:255',
                        'nick_name' => 'string|max:255',
//                        'birth_date' => 'date',
//                        'phone' => 'regex:/(62)[0-9]{9}/',
                        'email' => [
                            'required', 'string', 'email', 'max:255', 'unique:profiles,email,' . $profile->id
                        ]
                    ];

                    $items = [
                        'full_name' => $request->profile->full_name = property_exists($request->profile, 'full_name') ? $request->profile->full_name ?: $profile->full_name : $profile->full_name,
                        'nick_name' => $request->profile->nick_name = property_exists($request->profile, 'nick_name') ? $request->profile->nick_name ?: $profile->nick_name : $profile->nick_name,
                        'country' => $request->profile->country = property_exists($request->profile, 'country') ? $request->profile->country ?: $profile->country : $profile->country,
                        'state' => $request->profile->state = property_exists($request->profile, 'state') ? $request->profile->state ?: $profile->state : $profile->state,
                        'city' => $request->profile->city = property_exists($request->profile, 'city') ? $request->profile->city ?: $profile->city : $profile->city,
                        'address' => $request->profile->address = property_exists($request->profile, 'address') ? $request->profile->address ?: $profile->address : $profile->address,
                        'postcode' => $request->profile->postcode = property_exists($request->profile, 'postcode') ? $request->profile->postcode ?: $profile->postcode : $profile->postcode,
                        'gender' => $request->profile->gender = property_exists($request->profile, 'gender') ? $request->profile->gender ?: $profile->gender : $profile->gender,
                        'birth_date' => $request->profile->birth_date = property_exists($request->profile, 'birth_date') ? $request->profile->birth_date ?: $profile->birth_date : $profile->birth_date,
                        'mobile' => $profile->mobile = property_exists($request->profile, 'mobile') ? $request->profile->mobile ?: $profile->mobile : $profile->mobile,
                        'email' => $request->profile->email = property_exists($request->profile, 'email') ? $request->profile->email ?: $profile->email : $profile->email
                    ];

                    $profile->fill($items);

                    $this->setAuditableInformationFromRequest($profile, $request);

                    $brokenRules = $user->validate($rules, $request->profile);

                    if ($brokenRules->fails()) {
                        foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                            foreach ($value as $message) {
                                $response->addErrorMessageResponse($message);
                            }
                        }

                        return $response;
                    }

                    $relations["profile"] = [
                        "data" => $profile->toArray(),
                        "method" => RelationMethodType::PUSH()
                    ];

                    $profileRelations = [];

                    if ($request->media) {
                        $medias = [];

                        foreach ($request->media as $media) {
                            $medias[$media['media_id']] = [
                                'attribute' => $media['pivot']['attribute']
                            ];
                        }

                        $profileRelations["media"] = [
                            "data" => $medias,
                            "method" => RelationMethodType::SYNC()
                        ];
                    }

                    $unitOfWork->markDirtyAndSaveChange($this->_profileRepository, $profile, $profileRelations);
                }

                if ($request->roles) {
                    $relations["roles"] = [
                        "data" => $request->roles,
                        "method" => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_userRepository, $user, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('User profile updated');
            } else {
                $response->addErrorMessageResponse('User not found');
                $response->setStatus(404);
            }
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getUserGroup(int $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $response = $this->read([$this->_userRepository, 'findUserGroup'],
                [$id]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateUserGroup(UpdateUserGroupRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->_userRepository->find($request->id);

            if ($user) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $this->setAuditableInformationFromRequest($user, $request);

                if ($request->groups) {
                    $relations["groups"] = [
                        "data" => $request->groups,
                        "method" => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_userRepository, $user, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('User group updated');
            }

            $response->addErrorMessageResponse('User not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getUserRoles(int $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $response = $this->read([$this->_userRepository, 'findUserRoles'],
                [$id]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateUserRoles(UpdateUserRoleRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->_userRepository->find($request->id);

            if ($user) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $this->setAuditableInformationFromRequest($user, $request);

                if ($request->roles) {
                    $relations["roles"] = [
                        "data" => $request->roles,
                        "method" => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_userRepository, $user, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('User role updated');

                return $response;
            } else {
                $response->addErrorMessageResponse('User not found');
                $response->setStatus(404);
            }

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getUserPermissions(int $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $response = $this->read([$this->_userRepository, 'findUserPermissions'],
                [$id]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateUserPermissions(UpdateUserPermissionRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->_userRepository->find($request->id);

            if ($user) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $this->setAuditableInformationFromRequest($user, $request);

                if ($request->permissions) {
                    $permissions = [];

                    foreach ($request->permissions as $permission) {
                        $permissions[$permission['permission_id']] = [
                            'value' => $permission['pivot']['value']
                        ];
                    }

                    $relations["permissions"] = [
                        'data' => $permissions,
                        'method' => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_userRepository, $user, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('User permission updated');
            } else {
                $response->addErrorMessageResponse('User not found');
                $response->setStatus(404);
            }

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getUserAccesses(int $id, int $permissionId): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $response = $this->read([$this->_userRepository, 'findUserAccesses'],
                [$id, $permissionId]);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function updateUserAccesses(UpdateUserAccessRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->_userRepository->find($request->id);

            if ($user) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                if ($request->accesses) {
                    $accesses = [];

                    foreach ($request->accesses as $access) {
                        $accesses[$access['access_id']] = [
                            'value' => $access['pivot']['value']
                        ];
                    }

                    $relations["accesses"] = [
                        'data' => $accesses,
                        'method' => RelationMethodType::SYNC()
                    ];
                }

                $unitOfWork->markDirty($this->_userRepository, $user, $relations);
                $unitOfWork->commit();

                $response->addInfoMessageResponse('User access updated');
            } else {
                $response->addErrorMessageResponse('User not found');
                $response->setStatus(404);
            }

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
