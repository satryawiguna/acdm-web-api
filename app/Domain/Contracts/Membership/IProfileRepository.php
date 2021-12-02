<?php
namespace App\Domain\Contracts\Membership;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Profile\IProfileModelFacade;

interface IProfileRepository extends IRepository
{
    public function __construct(IProfileModelFacade $eloquent);
}
