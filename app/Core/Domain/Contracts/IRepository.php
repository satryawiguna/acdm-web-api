<?php
namespace App\Core\Domain\Contracts;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use Illuminate\Support\Collection;

interface IRepository extends IUnitOfWorkRepository
{
    public function newInstance(array $attributes = null): BaseEloquent;

    public function all(bool $isChunk = false): Collection;

    public function paginate(int $limit = 10, int $offset = 0, array $columns = ['*']): Collection;

    public function listSearch(ListSearchParameter $parameter, array $columns = ['*'], bool $isChunk = false): ListSearchResult;

    public function pageSearch(PageSearchParameter $parameter, array $columns = ['*']): PageSearchResult;

    public function find(int $id, array $columns = ['*']): BaseEloquent;

    public function findWithoutFail(int $id, array $columns = ['*']): BaseEloquent;

    public function findWhere(array $where, array $columns = ['*'], bool $isChunk = false): Collection;

    public function findFirstOrCreate(array $attributes): BaseEloquent;

    public function findFirstOrNull(array $attributes): BaseEloquent|null;

    public function deleteWhere(array $where): bool;

    public function count(): int;
}
