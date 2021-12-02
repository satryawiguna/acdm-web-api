<?php
namespace App\Infrastructure\Persistence\UnitOfWork;


use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Core\Domain\Contracts\IUnitOfWork;
use App\Core\Domain\Contracts\IUnitOfWorkRepository;
use App\Help\Infrastructures\Persistence\UnitOfWorks\Operation;
use App\Help\Infrastructures\Persistence\UnitOfWorks\WorkType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UnitOfWork implements IUnitOfWork
{
    private Collection $_operations;

    public function __construct()
    {
        $this->_operations = new Collection();
    }

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     */
    public function markNew(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                            array $relations = null): void
    {
        $this->_operations->push(new Operation(
            WorkType::INSERT(), $repository, $entity, null, $relations
        ));
    }

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     * @return BaseEloquent
     */
    public function markNewAndSaveChange(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                                         array $relations = null): BaseEloquent
    {
        return $repository->create($entity, $relations);
    }

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     */
    public function markDirty(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                              array $relations = null): void
    {
        $this->_operations->push(new Operation(
            WorkType::UPDATE(), $repository, $entity, null, $relations
        ));
    }

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param array|null $relations ex: ['group' => [1,2 etc...], 'role' => [1,2 etc...] etc...]
     * @return BaseEloquent
     */
    public function markDirtyAndSaveChange(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                                           array $relations = null): BaseEloquent
    {
        return $repository->update($entity, $relations);
    }

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param bool|null $isPermanentDelete
     * @param array|null $relations ex: ['group', 'role' etc...]
     */
    public function markRemove(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                               bool $isPermanentDelete = false, array $relations = null): void
    {
        $this->_operations->push(new Operation(
            WorkType::DELETE(), $repository, $entity, $isPermanentDelete, $relations
        ));
    }

    /**
     * @param IUnitOfWorkRepository $repository
     * @param BaseEloquent $entity
     * @param bool $isPermanentDelete
     * @param array|null $relations ex: ['group', 'role' etc...]
     * @return int
     */
    public function markRemoveAndSaveChange(IUnitOfWorkRepository $repository, BaseEloquent $entity,
                                            bool $isPermanentDelete = false, array $relations = null): int
    {
        return $repository->delete($entity, $isPermanentDelete, $relations);
    }

    /**
     * @return bool
     */
    public function commit(): bool
    {
        $response = true;

        try {
            DB::beginTransaction();

            foreach ($this->_operations as $operation) {
                switch ($operation->type->getValue()) {
                    case WorkType::INSERT()->getValue():
                        $operation->repository->create($operation->entity,
                            $operation->relations);
                        break;

                    case WorkType::UPDATE()->getValue():
                        $operation->repository->update($operation->entity,
                            $operation->relations);
                        break;

                    case WorkType::DELETE()->getValue():
                        $operation->repository->delete($operation->entity,
                            $operation->isPermanentDelete,
                            $operation->relations);
                        break;
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            $response = false;
            DB::rollBack();
        }

        $this->_operations = new Collection();

        return $response;
    }
}
