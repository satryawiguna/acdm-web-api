<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts;


use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use Illuminate\Support\Collection;

interface IModelFacade
{
    public function pluck(array $column, string $key = null): Collection;

    public function all(array $columns = ['*'], bool $isChunk = false): Collection;

    public function paginate(int $limit = 10, int $offset = 0, array $columns = ['*']): Collection;

    public function find(int $id, array $columns = ['*']);

    public function findWhere(array $where, array $columns = ['*'], bool $isChunk = false): Collection;

    public function countWhere(array $where, array $columns = ['*']): int;

    public function first(array $columns = ['*']): BaseEloquent;

    public function firstOrNull(array $attributes);

    public function findWhereIn(string $field, array $values, array $columns = ['*']): Collection;

    public function findWhereNotIn(string $field, array $values, array $columns = ['*']): Collection;

    public function findWithoutFail(int $id, array $columns = ['*']);

    public function firstOrCreate(array $attributes): BaseEloquent;

    public function create(array $attributes, array $relations = null): BaseEloquent;

    public function update(array $attributes, int $id, array $relations = null): BaseEloquent;

    public function updateOrCreate(array $attributes, array $values = []): BaseEloquent;

    public function delete(int $id, bool $isPermanentDelete = false, array $relations = null): int;

    public function deleteWhere(array $where): bool;

    public function orderBy(string $column, string $direction = 'asc'): IModelFacade;

    public function limitOffset(int $limit, int $offset): IModelFacade;

    public function with(array $relations): IModelFacade;

    public function has(array $relation): IModelFacade;

    public function doesntHave(array $relation): IModelFacade;

    public function whereHas(array $relation, \Closure $closure): IModelFacade;

    public function orWhereHas(array $relation, \Closure $closure): IModelFacade;

    public function hidden(array $fields): IModelFacade;

    public function visible(array $fields): IModelFacade;
}
