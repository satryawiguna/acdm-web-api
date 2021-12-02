<?php
namespace App\Infrastructure\Persistence\Repositories\System;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Core\Service\Request\PageSearchRequest;
use App\Domain\Contracts\System\IRoleRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IRoleModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    public function __construct(IRoleModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findRolesListSearch(ListSearchParameter $parameter, int $groupId = null, array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if (!is_null($keyword)) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if (!is_null($groupId)) {
            $this->_context->findWhereByGroupId($groupId);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->with(['groups' => function ($query) {
            $query->select('id', 'name', 'slug');
        }, 'permissions' => function ($query) {
            $query->select('id', 'name', 'slug');
        }])
            ->orderBy($column, $order)
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findRolesPageSearch(PageSearchRequest $parameter, int $groupId = null, array $columns = ['*']): PageSearchResult
    {
        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if (!is_null($keyword)) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if (!is_null($groupId)) {
            $this->_context->findWhereByGroupId($groupId);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->with(['groups' => function ($query) {
            $query->select('id', 'name', 'slug');
        }, 'permissions' => function ($query) {
            $query->select('id', 'name', 'slug');
        }])
            ->orderBy($column, $order)
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }

    public function findRolePermissions(int $id): Collection
    {
        $model = $this->_context->with([
            'permissions' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])->find($id);

        return $model->permissions;
    }

    public function findRoles(int $groupId = null, array $columns = ['*']): Collection
    {
        if (!is_null($groupId)) {
            $this->_context->findWhereByGroupId($groupId);
        }

        return $this->_context->with(['permissions' => function ($query) {
            $query->select('id', 'name', 'slug');
        }, 'vendor'])
            ->all($columns);
    }
}
