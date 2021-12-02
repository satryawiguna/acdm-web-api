<?php


namespace App\Infrastructure\Persistence\ModelFacades\MasterData;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IVendorModelFacade;

class VendorModelFacade extends BaseModelFacade implements IVendorModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'name' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?)', $parameter);

        return $this;
    }
}
