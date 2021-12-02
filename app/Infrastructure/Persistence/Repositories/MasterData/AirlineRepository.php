<?php
namespace App\Infrastructure\Persistence\Repositories\MasterData;


use App\Domain\Contracts\MasterData\IAirlineRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirlineModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class AirlineRepository extends BaseRepository implements IAirlineRepository
{
    public function __construct(IAirlineModelFacade $context)
    {
        parent::__construct($context);
    }
}
