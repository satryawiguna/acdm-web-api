<?php


namespace App\Infrastructure\Persistence\Repositories\MasterData;


use App\Domain\Contracts\MasterData\IVendorRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IVendorModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class VendorRepository extends BaseRepository implements IVendorRepository
{
    public function __construct(IVendorModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findVendorsByIds(array $ids, array $columns = ['*']): Collection
    {
        return $this->_context->findWhereIn('id', $ids, $columns);
    }

}
