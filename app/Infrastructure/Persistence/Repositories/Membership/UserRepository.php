<?php
namespace App\Infrastructure\Persistence\Repositories\Membership;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Domain\Contracts\Membership\IUserRepository;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Membership\IUserModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Profile\IProfileModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class UserRepository extends BaseRepository implements IUserRepository
{
    public $_profileModelFacade;

    public function __construct(IUserModelFacade $context, IProfileModelFacade $profileModelFacade)
    {
        parent::__construct($context);

        $this->_profileModelFacade = $profileModelFacade;
    }

    public function findUsers(): Collection
    {
        return $this->_context->with([
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'vendors' => function ($query) {
                $query->select('id', 'name', 'slug');
            }
        ])->all();
    }

    public function findUsersListSearch(ListSearchParameter $parameter, array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->with([
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'vendors' => function ($query) {
                $query->select('id', 'name', 'slug');
            }
        ])
            ->orderBy($column, $order)
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findUsersPageSearch(PageSearchParameter $parameter, array $columns = ['*']): PageSearchResult
    {
        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->with([
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'vendors' => function ($query) {
                $query->select('id', 'name', 'slug');
            }
        ])
            ->orderBy($column, $order)
            ->paginate($length, $offset, $column);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }

    public function findUser(int $id): BaseEloquent
    {
        return $this->_context->with([
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'vendors' => function ($query) {
                $query->select('id', 'name', 'slug');
            }
        ])->find($id, [
            'id', 'username', 'email', 'password',
            'last_login_ip', 'last_login_at'
        ]);
    }

    public function findUserProfile(int $id): BaseEloquent
    {
        $model = $this->_context->with([
            'profile' => function ($query) {
                $query->select('id', 'profileable_id', 'profileable_type', 'full_name', 'nick_name', 'country', 'state',
                    'city', 'address', 'postcode', 'gender', 'birth_date', 'mobile', 'email')
                    ->with(['media']);
            },
            'vendors' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            }])->find($id);

        $model->profile->roles = $model->roles;
        $model->profile->vendors = $model->vendors;

        return $model->profile;
    }

    public function findUserProfilesGroupByRole(): Collection
    {
        $selectRawQuery = "`??`.*, `?roles`.`id` as `role_id`, `?roles`.`name` as `role_name`";

        $users = $this->_context->selectRaw($selectRawQuery)
            ->join('user_roles', function($join) {
                $join->on($this->modelInstance()->getTable().'.id', '=', 'user_roles.user_id');
            })
            ->join('roles', function($join) {
                $join->on('user_roles.role_id', '=', 'roles.id');
            })
            ->with([
                'profile' => function ($query) {
                    $query->select('id', 'profileable_id', 'profileable_type', 'full_name', 'nick_name', 'country', 'state',
                        'city', 'address', 'postcode', 'gender', 'birth_date', 'mobile', 'email')
                        ->with(['media']);
                },
                'roles' => function ($query) {
                    $query->select('id', 'name', 'slug');
                },
                'vendors' => function ($query) {
                    $query->select('id', 'name', 'slug');
                }])->all();


        $users = $users->groupBy(function($q) {
            return strtoupper($q->role_name);
        });

        return $users;
    }

    public function findUserGroup(int $id): Collection
    {
        $model = $this->_context->with(['groups' => function ($query) {
            $query->select('id', 'name', 'slug', 'description');
        }])->find($id);

        return $model->groups;
    }

    public function findUserRoles(int $id): Collection
    {
        $model = $this->_context->with(['roles' => function ($query) {
            $query->select('id', 'name', 'slug', 'description');
        }])->find($id);

        return $model->roles;
    }

    public function findUserPermission(int $id, int $permissionId): BaseEloquent
    {
        return $this->_context->with(['permissions' => function ($query) use ($permissionId) {
            $query->select('id', 'name', 'slug', 'server', 'path', 'value')
                ->wherePivot('permission_id', $permissionId);
        }])->find($id);
    }

    public function findUserPermissions(int $id): Collection
    {
        $model = $this->_context->with(['permissions' => function ($query) {
            $query->select('id', 'name', 'slug', 'server', 'path', 'value');
        }])->find($id);

        return $model->permissions;
    }

    public function findUserAccess(int $id, int $permissionId, int $accessId): BaseEloquent
    {
        return $this->_context->with(['accesses' => function ($query) use ($permissionId, $accessId) {
            $query->select('id', 'name', 'slug', 'value')
                ->wherePivot('permission_id', $permissionId)
                ->wherePivot('access_id', $accessId);
        }])->find($id);
    }

    public function findUserAccesses(int $id, int $permissionId): Collection
    {
        $model = $this->_context->with(['accesses' => function ($query) use ($permissionId) {
            $query->select('id', 'name', 'slug', 'value')
                ->wherePivot('permission_id', $permissionId);
        }])->find($id);

        return $model->accesses;
    }

    public function findUserLogin(string $identity): Collection
    {
        return $this->_context->with([
            'groups' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'roles' => function ($query) {
                $query->select('id', 'name', 'slug')
                    ->with(['permissions' => function ($query) {
                        $query->select('id', 'name', 'slug', 'server', 'path', 'type', 'value')
                            ->with(['accesses' => function ($query) {
                                $query->select('id', 'name', 'slug', 'type', 'value');
                            }]);
                    }]);
            },
            'vendors' => function ($query) {
                $query->select('id', 'name', 'slug');
            },
            'profile' => function ($query) {
                $query->select('profileable_id', 'profileable_type', 'full_name', 'nick_name');
            }
        ])->findWhereByIdentity($identity)->all(['id', 'username', 'email',
            'password', 'status', 'last_login_ip', 'last_login_at']);

    }

    public function findUserLoginToApiDocument(string $email): Collection
    {
        return $this->_context->whereHas('groups', function($query) {
            $query->where('id', '=', 2);
        })->findWhere([
            ['email', '=', $email]
        ], ['id', 'username', 'email', 'password',
            'status', 'last_login_ip', 'last_login_at']);
    }
}
