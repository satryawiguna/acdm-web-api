<?php


namespace App\Domain\Contracts\MasterData;


use App\Core\Domain\Contracts\IRepository;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IOrganizationModelFacade;
use Illuminate\Support\Collection;

interface IOrganizationRepository extends IRepository
{
    public function __construct(IOrganizationModelFacade $eloquent);

    public function findOrganizationById(int $id): BaseEloquent;

    public function findAllWithChunk(): Collection;

    public function findOrganizationsListSearch(ListSearchParameter $parameter, int $countryId = null, array $columns = ['*']): ListSearchResult;

    public function findOrganizationsPageSearch(PageSearchParameter $parameter, int $countryId = null, array $columns = ['*']): PageSearchResult;
}
