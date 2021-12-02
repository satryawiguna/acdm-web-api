<?php


namespace App\Infrastructure\Persistence\ModelFacades\MasterData;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IOrganizationModelFacade;

class OrganizationModelFacade extends BaseModelFacade implements IOrganizationModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'name' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?)', $parameter);

        return $this;
    }

    public function findWhereByCountryId(int $countryId)
    {
        $this->model = $this->model->where("country_id", "=", $countryId);

        return $this;
    }
}
