<?php
namespace App\Domain\Contracts\MasterData;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirlineModelFacade;

interface IAirlineRepository extends IRepository
{
    public function __construct(IAirlineModelFacade $eloquent);
}
