<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\Membership;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface IUserModelFacade extends IModelFacade
{
    public function selectRaw(string $query);

    public function join(string $table, callable $function);

    public function findWhereByKeyword(string $keyword);

    public function findWhereByIdentity(string $identity);
}
