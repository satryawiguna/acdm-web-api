<?php
namespace App\Infrastructure\Persistence\ModelFacades\System;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IPermissionModelFacade;

class PermissionModelFacade extends BaseModelFacade implements IPermissionModelFacade
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
