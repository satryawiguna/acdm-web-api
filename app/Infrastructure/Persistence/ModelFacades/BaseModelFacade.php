<?php
namespace App\Infrastructure\Persistence\ModelFacades;


use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class BaseModelFacade implements IModelFacade
{
    public $model;

    protected $connection;

    protected $scopeQuery = null;

    public function __construct(BaseEloquent $model)
    {
        $this->model = $model;
        $this->connection = $this->model->getConnection();

        $this->boot();
    }

    public function __call($method, $args)
    {
        $this->applyScope();
        $this->resetScope();

        $model = $this->model;

        $this->resetModel();

        if ($this->isCallable($method)) {
            $result = call_user_func_array(array($model, $method), $args);

            return $result;
        }

        throw new \BadMethodCallException(sprintf('Call to undefined method %s::%s', get_class($this->model), $method));
    }


    public function modelInstance()
    {
        if ($this->model instanceof BaseEloquent) {
            return $this->model;
        }

        return $this->model->getModel();
    }

    public function newInstance(array $attributes = null)
    {
        return $this->modelInstance()->newInstance($attributes);
    }

    public function makeModel()
    {
        return $this->model = $this->newInstance([]);
    }

    public function resetModel()
    {
        $this->makeModel();
    }


    public function pluck(array $column, string $key = null): Collection
    {
        $results = $this->model->pluck($column, $key);

        $this->resetModel();

        return $results;
    }

    public function all($columns = ['*'], $isChunk = false): Collection
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        if ((!$isChunk)) {
            if ($this->model instanceof Builder) {
                $results = $this->model->get($columns);
            } else {
                $results = $this->model->all($columns);
            }
        } else {
            $results =  new Collection();

            $this->model->chunk(100, function($items) use($results) {
                foreach ($items as $item) {
                    $results->push($item);
                }
            });
        }


        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    public function paginate(int $limit = 10, int $offset = 0, array $columns = ['*']): Collection
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $query = $this->model->toBase();

        $select = 'distinct `'.env('DB_TABLE_PREFIX').$this->modelInstance()->getTable().'`.`id`';
        $total = $query->getCountForPagination([$this->connection->raw($select)]);

        if (!$total || (int) $limit <= 0 || $offset < 0 || $offset >= $total) {
            $this->resetModel();
            $this->resetScope();

            return collect([
                'results' => new Collection(),
                'total' => $total
            ]);
        }

        $results = $this->model->limit($limit)
            ->offset($offset)
            ->get($columns);

        $this->resetModel();
        $this->resetScope();

        return collect([
            'results' => $results,
            'total' => $total
        ]);
    }

    public function find(int $id, array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $model = $this->model->find($id, $columns);

        $this->resetModel();

        return $model;
    }

    public function findWhere(array $where, array $columns = ['*']): Collection
    {
        $this->applyScope();
        $this->applyConditions($where);

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $model = $this->model->get($columns);

        $this->resetModel();

        return $model;
    }

    public function findWhereIn(string $field, array $values, array $columns = ['*']): Collection
    {
        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $model = $this->model->whereIn($field, $values)->get($columns);

        $this->resetModel();

        return $model;
    }

    public function findWhereNotIn(string $field, array $values, array $columns = ['*']): Collection
    {
        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $model = $this->model->whereNotIn($field, $values)->get($columns);

        $this->resetModel();

        return $model;
    }

    public function findWithoutFail(int $id, array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $model = $this->model->find($id, $columns);

        $this->resetModel();

        return $model;
    }

    public function countWhere(array $where, array $columns = ['id']): int
    {
        $this->applyScope();
        $this->applyConditions($where);

        if ($columns == ['id']) {
            $columns = ["{$this->modelInstance()->getTable()}.id"];
        }

        $count = $this->model->count($columns);

        $this->resetModel();

        return $count;
    }

    public function first(array $columns = ['*']): BaseEloquent
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}"];
        }

        $results = $this->model->first($columns);

        $this->resetModel();

        return $results;
    }

    public function firstOrNull(array $attributes)
    {
        $this->applyConditions($attributes);

        $model = $this->model->first();

        $this->resetModel();

        return $model ?: null;
    }

    public function firstOrCreate(array $attributes): BaseEloquent
    {
        $this->applyConditions($attributes);

        $model = $this->model->first();

        $this->resetModel();

        return $model ?: $this->create($attributes);
    }

    public function create(array $attributes, array $relations = null): BaseEloquent
    {
        try {
            $model = $this->modelInstance()->newInstance($attributes);

            // Attach, CreateMany, SaveMany, Associate
            if (!is_null($relations)) {
                foreach ($relations as $key => $value) {
                    if ($value['method']->getValue() == RelationMethodType::ASSOCIATE()->getValue()) {
                        if (method_exists($model, $key)) {
                            $model->$key()->{$value['method']->getValue()}($value['data']);
                        }
                    }
                }

                $model->save();

                foreach ($relations as $key => $value) {
                    if ($value['method']->getValue() != RelationMethodType::ASSOCIATE()->getValue()) {
                        if (method_exists($model, $key)) {
                            $model->$key()->{$value['method']->getValue()}($value['data']);
                        }
                    }
                }
            } else {
                $model->save();
            }

            $this->resetModel();

            return $model;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function update(array $attributes, int $id, array $relations = null): BaseEloquent
    {
        try {
            $model = $this->modelInstance()->findOrFail($id);
            $model->fill($attributes);

            // Sync, Save, Push
            if (!is_null($relations)) {
                foreach ($relations as $key => $value) {
                    if (method_exists($model, $key)) {
                        switch ($value['method']->getValue()) {
                            case "push":
                                $model->save();

                                $data = $model->$key()->first()->fill($value['data']);
                                $model->$key()->save($data);
                                break;

                            default:
                                $model->save();

                                // HasMany or Many to Many
                                if (array_key_exists('detach', $value)
                                    && $value['detach']) {
                                    $model->$key()->{$value['method']->getValue()}($value['data'], $value['detach']);
                                } else {
                                    $model->$key()->{$value['method']->getValue()}($value['data']);
                                }
                                break;
                        }
                    }
                }
            } else {
                $model->save();
            }

            $this->resetModel();

            return $model;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function updateOrCreate(array $attributes, array $values = []): BaseEloquent
    {
        return $this->modelInstance()->updateOrCreate($attributes, $values);
    }

    public function delete(int $id, bool $isPermanentDelete = false, array $relations = null): int
    {
        $this->resetModel();

        // Detach
        if (!is_null($relations)) {
            foreach ($relations as $key => $value) {
                if (method_exists($this->modelInstance(), $key)) {
                    $this->modelInstance()->$key()->{$value['method']}($id);
                }
            }
        }

        if ($isPermanentDelete) {
            $model = $this->modelInstance()->find($id)->delete();
        } else {
            $model = $this->modelInstance()->destroy($id);
        }

        return $model;
    }

    public function deleteWhere(array $where): bool
    {
        $this->applyScope();
        $this->applyConditions($where);

        $deleted = $this->model->delete();

        $this->resetModel();

        return $deleted;
    }

    public function orderBy(string $column, string $direction = 'asc'): IModelFacade
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function limitOffset(int $limit, int $offset): IModelFacade
    {
        $this->model = $this->model->limit($limit)
            ->offset($offset);

        return $this;
    }

    public function with(array $relations): IModelFacade
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function has(array $relation): IModelFacade
    {
        $this->model = $this->model->has($relation);

        return $this;
    }

    public function doesntHave(array $relation): IModelFacade
    {
        $this->model = $this->model->doesntHave($relation);

        return $this;
    }

    public function whereHas(array $relation, \Closure $closure): IModelFacade
    {
        $this->model = $this->model->whereHas($relation, $closure);

        return $this;
    }

    public function orWhereHas($relation, \Closure $closure): IModelFacade
    {
        $this->model = $this->model->orWhereHas($relation, $closure);

        return $this;
    }

    public function hidden(array $fields): IModelFacade
    {
        $this->model->setHidden($fields);

        return $this;
    }

    public function visible(array $fields): IModelFacade
    {
        $this->model->setVisible($fields);

        return $this;
    }


    protected function boot()
    {
    }

    public function scopeQuery(Closure $scope)
    {
        $this->scopeQuery = $scope;

        return $this;
    }

    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;

            /** @var callable $callback */
            $this->model = $callback($this->model);
        }

        return $this;
    }

    public function resetScope()
    {
        $this->scopeQuery = null;

        return $this;
    }

    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    public function isCallable($method)
    {
        return method_exists($this->model, $method) ||
            method_exists($this->model->toBase(), $method);
    }

    public function raw($rawString)
    {
        return $this->connection->raw($rawString);
    }

    public function getTable()
    {
        return $this->modelInstance()->getTable();
    }
}
