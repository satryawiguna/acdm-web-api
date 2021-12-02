<?php
namespace App\Infrastructure\Persistence\Repositories\Departure;


use App\Domain\Contracts\Depature\IDepartureMetaRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureMetaModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class DepartureMetaRepository extends BaseRepository implements IDepartureMetaRepository
{
    public function __construct(IDepartureMetaModelFacade $context)
    {
        parent::__construct($context);
    }
}
