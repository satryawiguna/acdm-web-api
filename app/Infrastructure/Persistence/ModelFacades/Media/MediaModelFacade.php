<?php


namespace App\Infrastructure\Persistence\ModelFacades\Media;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Media\IMediaModelFacade;

class MediaModelFacade extends BaseModelFacade implements IMediaModelFacade
{
    public function findByIdWithoutFail(string $id, array $columns = ['*'])
    {
        $this->applyScope();

        if ($columns == ['*']) {
            $columns = ["{$this->modelInstance()->getTable()}.*"];
        }

        $model = $this->model->find($id, $columns);

        $this->resetModel();

        return $model;
    }

    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'original_name' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw("(original_name LIKE ?)", $parameter);

        return $this;
    }

    public function findWhereByUserId(int $userId)
    {
        $this->model = $this->model->where('user_id', '=', $userId);

        return $this;
    }

    public function findWhereByRoleId(int $roleId)
    {
        $this->model = $this->model->whereHas('users', function($query) use($roleId) {
            $query->whereHas('roles', function($query) use($roleId) {
                $query->where('id', '=', $roleId);
            });
        });
    }

    public function findWhereByCollection(string $collection)
    {
        $this->model = $this->model->where('collection', '=', strtoupper($collection));

        return $this;
    }
}
