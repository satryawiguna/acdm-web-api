<?php
namespace App\Domain\Contracts\System;


use App\Core\Domain\Contracts\IRepository;
use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IPermissionModelFacade;
use Illuminate\Support\Collection;

interface IPermissionRepository extends IRepository
{
    public function __construct(IPermissionModelFacade $eloquent);

    public function findPermissions(array $columns = ['*']): Collection;

    public function findPermissionsSearch(ListSearchParameter $parameter, array $columns = ['*']): ListSearchResult;

    public function findPermissionsPageSearch(PageSearchParameter $parameter, array $columns = ['*']): PageSearchResult;

    public function findPermissionAccesses(int $id): Collection;
}
