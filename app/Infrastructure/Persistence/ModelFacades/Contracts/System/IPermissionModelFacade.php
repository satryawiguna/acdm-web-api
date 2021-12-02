<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\System;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IPermissionModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);
}
