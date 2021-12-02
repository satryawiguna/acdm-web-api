<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IAirlineModelFacade  extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);
}
