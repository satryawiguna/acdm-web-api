<?php


namespace App\Infrastructure\Persistence\Repositories\Media;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Domain\Contracts\Media\IMediaRepository;
use App\Domain\Contracts\Media\PageSearchParameter;
use App\Domain\Contracts\Media\PageSearchResult;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Media\IMediaModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class MediaRepository extends BaseRepository implements IMediaRepository
{
    public function __construct(IMediaModelFacade $eloquent)
    {
        parent::__construct($eloquent);
    }

    public function findMediaById(string $id, array $columns = ['*']): BaseEloquent
    {
        return $this->_context->findByIdWithoutFail($id, $columns);
    }

    public function findMediasListSearch(ListSearchParameter $parameter, int $userId = null, int $roleId = null, string $collection = 'PUBLIC', array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if (!is_null($userId)) {
            $this->_context->findWhereByUserId($userId);
        }

        if (!is_null($roleId)) {
            $this->_context->findWhereByRoleId($userId);
        }

        if (!is_null($collection)) {
            $this->_context->findWhereByCollection($collection);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->orderBy($column, $order)
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findMediasPageSearch(PageSearchParameter $parameter, int $userId = null, int $roleId = null, string $collection= 'PUBLIC', array $columns = ['*']): PageSearchResult
    {
        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if (!is_null($userId)) {
            $this->_context->findWhereByUserId($userId);
        }

        if (!is_null($roleId)) {
            $this->_context->findWhereByRoleId($userId);
        }

        if (!is_null($collection)) {
            $this->_context->findWhereByCollection($collection);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->orderBy($column, $order)
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }
}
