<?php
namespace App\Infrastructure\Persistence\ModelFacades\Membership;


use App\Infrastructure\Persistence\ModelFacades\Contracts\Membership\IUserModelFacade;
use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use Illuminate\Support\Facades\DB;

class UserModelFacade extends BaseModelFacade implements IUserModelFacade
{
    public function selectRaw(string $query)
    {
        $this->model = $this->model->select(DB::raw(strtr($query, [
            '?' => env('DB_TABLE_PREFIX'),
            '??' => env('DB_TABLE_PREFIX').$this->modelInstance()->getTable()
        ])));

        return $this;
    }

    public function join(string $table, callable $function)
    {
        $this->model = $this->model->join($table, $function);

        return $this;
    }

    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'email' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(email LIKE ?)', $parameter);

        return $this;
    }

    public function findWhereByIdentity(string $identity)
    {
        $this->model = $this->model->where('email', $identity)
            ->whereHas('groups', function($query) {
                $query->where('id', '=', 1);
            })
            ->orWhere('username', $identity)
            ->whereHas('groups', function($query) {
                $query->where('id', '=', 1);
            });

        return $this;
    }
}
