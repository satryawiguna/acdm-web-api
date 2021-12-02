<?php
namespace App\Core\Domain\Contracts;


interface IUnitOfWorkFactory
{
    public function create(): IUnitOfWork;
}
