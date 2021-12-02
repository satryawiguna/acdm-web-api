<?php
namespace App\Help\Infrastructures\Persistence\UnitOfWorks;


use App\Core\Domain\Contracts\IUnitOfWorkRepository;
use App\Help\Infrastructure\Persistence\UnitOfWork\RelationMethodType;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;

class Operation
{
    public WorkType $type;

    public IUnitOfWorkRepository $repository;

    public BaseEloquent $entity;

    public $isPermanentDelete;

    public $relations;

    public function __construct(WorkType $type, IUnitOfWorkRepository $repository, BaseEloquent $entity, $isPermanentDelete = null, $relations = null)
    {
        $this->type = $type;

        $this->repository = $repository;

        $this->entity = $entity;

        $this->isPermanentDelete = $isPermanentDelete;

        $this->relations = $relations;
    }

    /**
     * @return WorkType
     */
    public function getType(): WorkType
    {
        return $this->type;
    }

    /**
     * @param WorkType $type
     */
    public function setType(WorkType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return IUnitOfWorkRepository
     */
    public function getRepository(): IUnitOfWorkRepository
    {
        return $this->repository;
    }

    /**
     * @param IUnitOfWorkRepository $repository
     */
    public function setRepository(IUnitOfWorkRepository $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * @return BaseEloquent|null
     */
    public function getEntity(): ?BaseEloquent
    {
        return $this->entity;
    }

    /**
     * @param BaseEloquent|null $entity
     */
    public function setEntity(?BaseEloquent $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return bool|null
     */
    public function getIsPermanentDelete(): ?bool
    {
        return $this->isPermanentDelete;
    }

    /**
     * @param bool|null $isPermanentDelete
     */
    public function setIsPermanentDelete(?bool $isPermanentDelete): void
    {
        $this->isPermanentDelete = $isPermanentDelete;
    }

    /**
     * @return array|null
     */
    public function getRelations(): ?array
    {
        return $this->relations;
    }

    /**
     * @param array|null $relations
     */
    public function setRelations(?array $relations): void
    {
        $this->relations = $relations;
    }
}
