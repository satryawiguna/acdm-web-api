<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\System;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IRoleModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);

    public function findWhereByGroupId(int $groupId);
}
