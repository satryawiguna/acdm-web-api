<?php
namespace App\Domain\Contracts\System;


use App\Core\Domain\Contracts\IRepository;
use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Core\Service\Request\PageSearchRequest;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IRoleModelFacade;
use Illuminate\Support\Collection;

interface IRoleRepository extends IRepository
{
    public function __construct(IRoleModelFacade $eloquent);

    public function findRolesListSearch(ListSearchParameter $parameter, int $groupId = null, array $columns = ['*']): ListSearchResult;

    public function findRolesPageSearch(PageSearchRequest $parameter, int $groupId = null, array $columns = ['*']): PageSearchResult;

    public function findRolePermissions(int $id): Collection;

    public function findRoles(int $groupId = null, array $columns = ['*']): Collection;
}
