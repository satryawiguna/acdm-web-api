<?php
namespace App\Domain\Contracts\System;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IAccessModelFacade;
use Ramsey\Collection\Collection;

interface IAccessRepository extends IRepository
{
    public function __construct(IAccessModelFacade $eloquent);
}
