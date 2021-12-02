<?php


namespace App\Infrastructure\Persistence\Repositories\MasterData;


use App\Domain\Contracts\MasterData\ICountryRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\ICountryModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class CountryRepository extends BaseRepository implements ICountryRepository
{
    public function __construct(ICountryModelFacade $context)
    {
        parent::__construct($context);
    }
}
