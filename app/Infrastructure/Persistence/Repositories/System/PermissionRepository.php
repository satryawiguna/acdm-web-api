<?php
namespace App\Infrastructure\Persistence\Repositories\System;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Domain\Contracts\Membership\PageSearchRequest;
use App\Domain\Contracts\System\IPermissionRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IPermissionModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class PermissionRepository extends BaseRepository implements IPermissionRepository
{
    public function __construct(IPermissionModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findPermissions(array $columns = ['*']): Collection
    {
        return $this->_context->with([
            'accesses' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->get();
    }

    public function findPermissionsSearch(ListSearchParameter $parameter, array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if (!is_null($keyword)) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->with(['accesses' => function ($query) {
            $query->select('id', 'name', 'slug');
        }])
            ->orderBy($column, $order)
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findPermissionsPageSearch(PageSearchParameter $parameter, array $columns = ['*']): PageSearchResult
    {
        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if (!is_null($keyword)) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->with(['accesses' => function ($query) {
            $query->select('id', 'name', 'slug');
        }])
            ->orderBy($column, $order)
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }

    public function findPermissionAccesses(int $id): Collection
    {
        $model = $this->_context->with([
            'accesses' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])->find($id);

        return $model->accesses;
    }
}
