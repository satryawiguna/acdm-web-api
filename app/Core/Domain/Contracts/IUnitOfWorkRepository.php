<?php
namespace App\Core\Domain\Contracts;


use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;

interface IUnitOfWorkRepository
{
    public function create(BaseEloquent $entity,
                           array $relations = null): BaseEloquent;

    public function update(BaseEloquent $entity,
                           array $relations = null): BaseEloquent;

    public function delete(BaseEloquent $entity,
                           bool $isPermanentDelete = false,
                           array $relations = null): int;
}
