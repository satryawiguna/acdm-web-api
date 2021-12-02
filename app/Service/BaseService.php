<?php
namespace App\Service;


use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Core\Service\Request\AuditableRequest;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

abstract class BaseService
{
    protected function read(callable $readFunction, array $arguments = []): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        /** @var object $data */
        if (count($arguments) > 0) {
            $data = call_user_func_array($readFunction, $arguments);
        } else {
            $data = call_user_func($readFunction);
        }

        $response->dto = $data ?? new \stdClass();

        return $response;
    }

    protected function search(callable $searchFunction, array $arguments = []): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        /** @var array $datas */
        if (count($arguments) > 0) {
            $datas = call_user_func_array($searchFunction, $arguments);
        } else {
            $datas = call_user_func($searchFunction);
        }

//        foreach ($datas as $data) {
//            $response->dtoCollection()->push($data);
//        }

        $datas->map(function($data, $key) use($response) {
            $response->dtoCollection()->put($key, $data);
        });

        return $response;
    }

    protected function listSearch(callable $listSearchFunction, ListSearchRequest $request, array $arguments = []): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        array_unshift($arguments, new ListSearchParameter(
            $request->search,
            $request->sort
        ));

        /** @var ListSearchResult $datas */
        $datas = call_user_func_array($listSearchFunction, $arguments);

//        foreach ($datas->result as $data) {
//            $response->dtoCollection()->push($data);
//        }

        $datas->result->map(function($data, $key) use($response) {
            $response->dtoCollection()->put($key, $data);
        });

        $response->totalCount = $datas->count;

        return $response;
    }

    protected function pageSearch(callable $pageSearchFunction, PageSearchRequest $request, array $arguments = []): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        array_unshift($arguments, new PageSearchParameter(
            $request->pagination,
            $request->search,
            $request->sort
        ));

        /** @var PageSearchResult $datas */
        $datas = call_user_func_array($pageSearchFunction, $arguments);

//        foreach ($datas->result as $data) {
//            $response->dtoCollection()->push($data);
//        }

        $datas->result->map(function($data, $key) use($response) {
            $response->dtoCollection()->put($key, $data);
        });

        $response->totalCount = $datas->count;
        $response->totalPage = ceil($datas->count / $request->pagination['length']);

        return $response;
    }

    protected function setAuditableInformationFromRequest($entity, AuditableRequest $request)
    {
        if ($entity instanceof BaseEloquent) {
            if (!$entity->getKey()) {
                $entity->setCreatedInfo($request->getRequestBy());
            } else {
                $entity->setUpdatedInfo($request->getRequestBy());
            }
        }

        // Usage for one to many relation
        if (is_array($entity)) {
            $date = new DateTime('now');

            if (!array_key_exists('id', $entity) || $entity['id'] == 0) {
                $entity['created_by'] = $request->getRequestBy();
                $entity['created_at'] = $date->format(Config::get('datetime.format.database_datetime'));
            } else {
                $entity['updated_by'] = $request->getRequestBy();
                $entity['updated_at'] = $date->format(Config::get('datetime.format.database_datetime'));
            }

            return $entity;
        }
    }
}
