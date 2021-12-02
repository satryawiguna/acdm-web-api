<?php
namespace App\Infrastructure\Persistence\Repositories;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;
use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements IRepository
{
    protected IModelFacade $_context;


    public function __construct(IModelFacade $context)
    {
        $this->_context = $context;
    }

    public function __call(string $method, array $args)
    {
        if (method_exists($this->_context, $method)) {
            return call_user_func_array(array($this->_context, $method), $args);
        }

        if ($this->_context->isCallable($method)) {
            return call_user_func_array(array($this->_context, $method), $args);
        }

        throw new \BadMethodCallException(
            sprintf('Call to undefined method %s::%s', get_class($this->_context), $method)
        );
    }


    public function newInstance(array $attributes = null): BaseEloquent
    {
        return $this->_context->newInstance($attributes);
    }

    public function all(bool $isChunk = false): Collection
    {
        return $this->_context->all($isChunk);
    }

    public function paginate(int $limit = 10, int $offset = 0, array $columns = ['*']): Collection
    {
        return $this->_context->paginate($limit, $offset, $columns);
    }

    public function listSearch(ListSearchParameter $parameter, array $columns = ['*'], bool $isChunk = false): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->orderBy($column, $order)
            ->all($columns, $isChunk);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function pageSearch(PageSearchParameter $parameter, array $columns = ['*']): PageSearchResult
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

        $model = $this->_context->orderBy($column, $order)
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }

    public function find(int $id, array $columns = ['*']): BaseEloquent
    {
        return $this->_context->find($id, $columns);
    }

    public function findWithoutFail(int $id, array $columns = ['*']): BaseEloquent
    {
        return $this->_context->findWithoutFail($id, $columns);
    }

    public function findWhere(array $where, array $columns = ['*'], bool $isChunk = false): Collection
    {
        return $this->_context->findWhere($where, $columns, $isChunk);
    }

    public function findFirstOrCreate(array $attributes): BaseEloquent
    {
        return $this->_context->firstOrCreate($attributes);
    }

    public function findFirstOrNull(array $attributes): BaseEloquent|null
    {
        return $this->_context->firstOrNull($attributes);
    }

    public function deleteWhere(array $where): bool
    {
        return $this->_context->deleteWhere($where);
    }

    public function count(): int
    {
        return $this->_context->all()->count();
    }

    public function create(BaseEloquent $entity,
                           array $relations = null): BaseEloquent
    {
        return $this->_context->create($entity->getAttributes(), $relations);
    }

    public function update(BaseEloquent $entity,
                           array $relations = null): BaseEloquent
    {
        return $this->_context->update($entity->getAttributes(), $entity->getKey(), $relations);
    }

    public function delete(BaseEloquent $entity,
                           bool $isPermanentDelete = false,
                           array $relations = null): int
    {
        return $this->_context->delete($entity->getKey(), $isPermanentDelete, $relations);
    }

}
