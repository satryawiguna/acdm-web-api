<?php
namespace App\Domain\Contracts\Depature;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureMetaModelFacade;

interface IDepartureMetaRepository extends IRepository
{
    public function __construct(IDepartureMetaModelFacade $eloquent);
}
