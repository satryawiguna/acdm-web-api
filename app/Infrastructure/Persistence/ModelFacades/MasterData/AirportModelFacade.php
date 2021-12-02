<?php
namespace App\Infrastructure\Persistence\ModelFacades\MasterData;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirportModelFacade;

class AirportModelFacade extends BaseModelFacade implements IAirportModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'name' => '%' . $keyword . '%',
            'iata' => '%' . $keyword . '%',
            'icao' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?
            OR iata LIKE ?
            OR icao LIKE ?)', $parameter);

        return $this;
    }

    public function findWhereByIata(string $iata)
    {
        $this->model = $this->model->where('iata', '=', $iata);

        return $this;
    }

    public function findWhereByIcao(string $icao)
    {
        $this->model = $this->model->where('icao', '=', $icao);

        return $this;
    }
}
