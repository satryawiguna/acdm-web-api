<?php


namespace App\Domain\Contracts\MasterData;


use App\Core\Domain\Contracts\IRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IVendorModelFacade;
use Illuminate\Support\Collection;


interface IVendorRepository extends IRepository
{
    public function __construct(IVendorModelFacade $eloquent);

    public function findVendorsByIds(array $ids, array $columns = ['*']): Collection;
}
