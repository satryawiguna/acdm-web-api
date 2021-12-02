<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IVendorModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);
}
