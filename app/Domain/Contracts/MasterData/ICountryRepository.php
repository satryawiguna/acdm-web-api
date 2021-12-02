<?php


namespace App\Domain\Contracts\MasterData;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\ICountryModelFacade;

interface ICountryRepository extends IRepository
{
    public function __construct(ICountryModelFacade $eloquent);

}
