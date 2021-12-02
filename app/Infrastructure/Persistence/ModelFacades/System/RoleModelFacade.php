<?php
namespace App\Infrastructure\Persistence\ModelFacades\System;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IRoleModelFacade;

class RoleModelFacade extends BaseModelFacade implements IRoleModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'name' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?)', $parameter);

        return $this;
    }

    public function findWhereByGroupId(int $groupId)
    {
        $this->model = $this->model->where('group_id', '=', $groupId);

        return $this;
    }
}
