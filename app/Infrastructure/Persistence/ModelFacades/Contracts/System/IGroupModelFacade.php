<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\System;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IGroupModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);
}
