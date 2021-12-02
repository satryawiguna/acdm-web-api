<?php
namespace App\Domain\Contracts\System;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IGroupModelFacade;

interface IGroupRepository extends IRepository
{
    public function __construct(IGroupModelFacade $eloquent);
}
