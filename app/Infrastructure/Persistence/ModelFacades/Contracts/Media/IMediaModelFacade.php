<?php


namespace App\Infrastructure\Persistence\ModelFacades\Contracts\Media;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IMediaModelFacade extends IModelFacade
{
    public function findByIdWithoutFail(string $id, array $columns = ['*']);

    public function findWhereByKeyword(string $keyword);

    public function findWhereByUserId(int $userId);

    public function findWhereByRoleId(int $roleId);

    public function findWhereByCollection(string $collection);
}
