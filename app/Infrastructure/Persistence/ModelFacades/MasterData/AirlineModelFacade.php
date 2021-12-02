<?php
namespace App\Infrastructure\Persistence\ModelFacades\MasterData;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirlineModelFacade;

class AirlineModelFacade extends BaseModelFacade implements IAirlineModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'name' => '%' . $keyword . '%',
            'icao' => '%' . $keyword . '%',
            'iata' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
        OR icao LIKE ?
        OR iata LIKE ?)', $parameter);

        return $this;
    }
}
