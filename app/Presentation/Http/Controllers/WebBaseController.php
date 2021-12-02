<?php
namespace App\Presentation\Http\Controllers;


use App\Core\Service\Request\AuditableRequest;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WebBaseController extends Controller
{
    public function __construct()
    {
    }

    protected function getBassicSuccess(BasicResponse $response)
    {
        return [
            'isSuccess' => true,
            'messages' => $response->getMessageResponseInfoTextArray()
        ];
    }

    protected function getBassicSuccessWithString(BasicResponse $response, string $message)
    {
        return [
            'isSuccess' => true,
            'message' => $message
        ];
    }

    protected function getBassicSuccessWithData(BasicResponse $response, object $data)
    {
        return [
            'isSuccess' => true,
            'messages' => $response->getMessageResponseInfoTextArray(),
            'data' => $data
        ];
    }

    protected function getBasicSuccessWithStringData(BasicResponse $response, string $message, object $data)
    {
        return [
            'isSuccess' => true,
            'message' => $message,
            'data' => $data
        ];
    }

    protected function getError(BasicResponse $response)
    {
        return [
            'isSuccess' => false,
            'messages' => $response->getMessageResponseErrorTextArray()
        ];
    }

    protected function getErrorWithString(BasicResponse $response, string $message)
    {
        return [
            'isSuccess' => false,
            'messages' => $message
        ];
    }

    protected function getErrorWithData(BasicResponse $response, object $data)
    {
        return [
            'isSuccess' => false,
            'messages' => $response->getMessageResponseErrorTextArray(),
            'data' => $data
        ];
    }

    protected function getErrorWithStringData(BasicResponse $response, string $message, object $data)
    {
        return [
            'isSuccess' => false,
            'message' => $message,
            'data' => $data
        ];
    }

    protected function generateListSearchParameter(Request $request): ListSearchRequest
    {
        $search = '';

        if ($request->input('search')) {
            $search = $request->input('search');
        }

        $sort = [
            'order' => 'DESC',
            'column' => 'id'
        ];

        if ($request->input('sort')) {
            $sort = $request->input('sort');
        }

        $listSearchRequest = new ListSearchRequest();
        $listSearchRequest->search = $search;
        $listSearchRequest->sort = $sort;

        return $listSearchRequest;
    }

    protected function generatePageSearchParameter(Request $request): PageSearchRequest
    {
        $search = '';

        if ($request->input('search')) {
            $search = $request->input('search');
        }

        $pagination = [
            'page' => 1,
            'length' => 10
        ];

        if ($request->input('pagination')) {
            $pagination = $request->input('pagination');
        }

        $sort = [
            'order' => 'DESC',
            'column' => 'id'
        ];

        if ($request->input('sort')) {
            $sort = $request->input('sort');
        }

        $pageSearchRequest = new PageSearchRequest();
        $pageSearchRequest->pagination = $pagination;
        $pageSearchRequest->search = $search;
        $pageSearchRequest->sort = $sort;

        return $pageSearchRequest;
    }

    protected function getListSearch(Request $request,
                                     callable $dtoCollectionToRowJsonMethod,
                                     callable $searchMethod,
                                     array $arguments = [])
    {
        $parameter = $this->generateListSearchParameter($request);

        array_unshift($arguments, $parameter);

        $response = call_user_func_array($searchMethod, $arguments);
        $rowData = $dtoCollectionToRowJsonMethod($response);

        return $this->getListSearchResponse($rowData, $response);
    }

    protected function getPageSearch(Request $request,
                                     callable $dtoCollectionToRowJsonMethod,
                                     callable $searchMethod,
                                     array $arguments = [])
    {
        $parameter = $this->generatePageSearchParameter($request);

        array_unshift($arguments, $parameter);

        $response = call_user_func_array($searchMethod, $arguments);
        $rowData = $dtoCollectionToRowJsonMethod($response);

        return $this->getPageSearchResponse($rowData, $response, $parameter);
    }

    protected function getListSearchResponse(Collection $rowData,
                                             GenericListSearchResponse $response)
    {
        return [
            'total' => $response->getTotalCount(),
            'rows' => $rowData
        ];
    }

    protected function getPageSearchResponse(Collection $rowData,
                                             GenericPageSearchResponse $response,
                                             PageSearchRequest $request)
    {
        return [
            'meta' => [
                'page' => (integer)$request->pagination['page'],
                'length' => (integer)$request->pagination['length'],
                'pages' => $response->getTotalPage(),
                'total' => $response->getTotalCount(),
                'order' => $request->sort['order'],
                'column' => $request->sort['column']
            ],
            'rows' => $rowData
        ];
    }

    protected function getDataResponse(object $data)
    {
        return $data;
    }

    /**
     * @param AuditableRequest $request
     */
    protected function setRequestAuthor(AuditableRequest $request)
    {
        if (Auth::user()) {
            $request->request_by = Auth::user()->username;
        } else {
            $request->request_by = 'system';
        }
    }
}
