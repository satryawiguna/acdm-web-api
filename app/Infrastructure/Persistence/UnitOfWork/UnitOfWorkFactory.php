<?php
namespace App\Infrastructure\Persistence\UnitOfWork;


use App\Core\Domain\Contracts\IUnitOfWork;
use App\Core\Domain\Contracts\IUnitOfWorkFactory;

class UnitOfWorkFactory implements IUnitOfWorkFactory
{
    public function create(): IUnitOfWork
    {
        return new UnitOfWork();
    }
}
