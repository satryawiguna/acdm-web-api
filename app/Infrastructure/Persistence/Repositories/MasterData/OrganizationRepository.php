<?php


namespace App\Infrastructure\Persistence\Repositories\MasterData;


use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Domain\Contracts\MasterData\IOrganizationRepository;
use App\Domain\Contracts\MasterData\ListSearchParameter;
use App\Domain\Contracts\MasterData\ListSearchResult;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IOrganizationModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class OrganizationRepository extends BaseRepository implements IOrganizationRepository
{
    public function __construct(IOrganizationModelFacade $context)
    {
        parent::__construct($context);
    }

    public function findOrganizationById(int $id): BaseEloquent
    {
        return $this->_context->with(["country", "media"])
            ->findWithoutFail($id);
    }

    public function findAllWithChunk(): Collection
    {

        return $this->_context
            ->with(['vendors', 'media'])
            ->all(['*'], true);
    }

    public function findOrganizationsListSearch(ListSearchParameter $parameter, int $countryId = null, array $columns = ['*']): ListSearchResult
    {
        $listSearchResult = new ListSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if ($countryId) {
            $this->_context->findWhereByCountryId($countryId);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];

        $model = $this->_context->orderBy($column, $order)
            ->with(['vendors', 'media'])
            ->all($columns);

        $listSearchResult->result = $model;
        $listSearchResult->count = $model->count();

        return $listSearchResult;
    }

    public function findOrganizationsPageSearch(PageSearchParameter $parameter, int $countryId = null, array $columns = ['*']): PageSearchResult
    {
        $pageSearchResult = new PageSearchResult();

        $keyword = $parameter->search;

        if ($keyword) {
            $this->_context->findWhereByKeyword($keyword);
        }

        if ($countryId) {
            $this->_context->findWhereByCountryId($countryId);
        }

        $column = $parameter->sort['column'];
        $order = $parameter->sort['order'];
        $length = $parameter->pagination['length'];
        $offset = $parameter->pagination['length'] * ($parameter->pagination['page'] - 1);

        $model = $this->_context->orderBy($column, $order)
            ->with(['vendors', 'media'])
            ->paginate($length, $offset, $columns);

        $pageSearchResult->result = $model->get('results');
        $pageSearchResult->count = $model->get('total');

        return $pageSearchResult;
    }
}
