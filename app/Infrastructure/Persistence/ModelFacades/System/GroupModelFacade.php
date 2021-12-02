<?php
namespace App\Infrastructure\Persistence\ModelFacades\System;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IGroupModelFacade;

class GroupModelFacade extends BaseModelFacade implements IGroupModelFacade
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
