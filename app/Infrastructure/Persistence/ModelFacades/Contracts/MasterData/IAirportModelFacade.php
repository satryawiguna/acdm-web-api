<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IAirportModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);

    public function findWhereByIata(string $iata);

    public function findWhereByIcao(string $icao);
}
