<?php
namespace App\Core\Domain\Contracts;


use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;

interface IUnitOfWork
{
    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     */
    public function markNew(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                            array $relations = null): void;

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     * @return BaseEloquent
     */
    public function markNewAndSaveChange(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                                         array $relations = null): BaseEloquent;

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     */
    public function markDirty(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                              array $relations = null): void;

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     * @return BaseEloquent
     */
    public function markDirtyAndSaveChange(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                                           array $relations = null): BaseEloquent;

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param bool|null $isPermanentDelete
     * @param array|null $relations ex: ['group', 'role' etc...]
     */
    public function markRemove(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                               bool $isPermanentDelete = false, array $relations = null): void;

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param bool|null $isPermanentDelete
     * @param array|null $relations ex: ['group', 'role' etc...]
     * @return int
     */
    public function markRemoveAndSaveChange(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                                            bool $isPermanentDelete = false, array $relations = null): int;

    /**
     * @return bool
     */
    public function commit(): bool;
}
