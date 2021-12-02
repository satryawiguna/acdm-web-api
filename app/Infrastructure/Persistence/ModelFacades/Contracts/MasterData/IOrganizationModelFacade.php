<?php


namespace App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IOrganizationModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);

    public function findWhereByCountryId(int $countryId);
}
