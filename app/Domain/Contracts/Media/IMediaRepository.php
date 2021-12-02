<?php


namespace App\Domain\Contracts\Media;


use App\Core\Domain\Contracts\IRepository;
use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Media\IMediaModelFacade;

interface IMediaRepository extends IRepository
{
    public function __construct(IMediaModelFacade $eloquent);

    public function findMediaById(string $id, array $columns = ['*']): BaseEloquent;

    public function findMediasListSearch(ListSearchParameter $parameter, int $userId = null, int $roleId = null, string $collection = 'PUBLIC', array $columns = ['*']): ListSearchResult;

    public function findMediasPageSearch(PageSearchParameter $parameter, int $userId = null, int $roleId = null, string $collection = 'PUBLIC', array $columns = ['*']): PageSearchResult;
}
