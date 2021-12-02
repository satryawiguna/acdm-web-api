<?php
namespace App\Presentation\Http\Controllers\Api;


use App\Core\Service\Request\AuditableRequest;
use App\Core\Service\Request\ListSearchRequest;
use App\Core\Service\Request\PageSearchRequest;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ApiBaseController extends Controller
{
    /**
     * ApiBaseController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicSuccessJson",
     *     title="Get Basic Success Json",
     *     description="Get basic success json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is success property",
     *         type="boolean"
     *     ),
     *     @OA\Property(
     *         property="messages",
     *         description="messages property",
     *         type="array",
     *         @OA\Items()
     *     )
     * )
     *
     * @param BasicResponse $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicSuccessJson(BasicResponse $response)
    {
        return response()->json([
            'isSuccess' => true,
            'messages' => $response->getMessageResponseInfoTextArray()
        ], $response->getStatus());
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicSuccessWithStringJson",
     *     title="Get Basic Success With String Json",
     *     description="Get basic success with string json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is success property",
     *         type="boolean"
     *     ),
     *     @OA\Property(
     *         property="message",
     *         description="message property",
     *         type="string"
     *     )
     * )
     *
     * @param BasicResponse $response
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicSuccessWithStringJson(BasicResponse $response, string $message)
    {
        return response()->json([
            'isSuccess' => true,
            'message' => $message
        ], $response->getStatus());
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicSuccessWithDataJson",
     *     title="Get Basic Success With Data Json",
     *     description="Get basic success with data json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is success property",
     *         type="boolean"
     *     ),
     *     @OA\Property(
     *         property="messages",
     *         description="messages property",
     *         type="array",
     *         @OA\Items()
     *     ),
     *     oneOf={
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="object"
     *         ),
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="array",
     *             @OA\Items()
     *         )
     *     }
     * )
     *
     * @param BasicResponse $response
     * @param object $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicSuccessWithDataJson(BasicResponse $response, object $data)
    {
        return response()->json([
            'isSuccess' => true,
            'messages' => $response->getMessageResponseInfoTextArray(),
            'data' => $data
        ], $response->getStatus());
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicSuccessWithStringDataJson",
     *     title="Get Basic Success With String Data Json",
     *     description="Get basic success with string data json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is success property",
     *         type="boolean"
     *     ),
     *     @OA\Property(
     *         property="message",
     *         description="message property",
     *         type="string"
     *     ),
     *     oneOf={
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="object"
     *         ),
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="array",
     *             @OA\Items()
     *         )
     *     }
     * )
     *
     * @param BasicResponse $response
     * @param string $message
     * @param object $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicSuccessWithStringDataJson(BasicResponse $response, string $message, object $data)
    {
        return response()->json([
            'isSuccess' => true,
            'message' => $message,
            'data' => $data
        ], $response->getStatus());
    }



    /**
     * @OA\Schema(
     *     schema="GetBasicErrorJson",
     *     title="Get Basic Error Json",
     *     description="Get basic error json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is success property",
     *         type="boolean",
     *         example=false
     *     ),
     *     @OA\Property(
     *         property="messages",
     *         description="messages property",
     *         type="array",
     *         @OA\Items(),
     *         example={}
     *     )
     * )
     *
     * @param BasicResponse $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getErrorJson(BasicResponse $response)
    {
        return response()->json([
            'isSuccess' => false,
            'messages' => $response->getMessageResponseErrorTextArray()
        ], $response->getStatus());
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicErrorWithStringJson",
     *     title="Get Basic Error With String Json",
     *     description="Get basic error with string json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is error property",
     *         type="boolean",
     *         example=false
     *     ),
     *     @OA\Property(
     *         property="message",
     *         description="message property",
     *         type="string"
     *     )
     * )
     *
     * @param BasicResponse $response
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getErrorWithStringJson(BasicResponse $response, string $message)
    {
        return response()->json([
            'isSuccess' => false,
            'messages' => $message
        ], $response->getStatus());
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicErrorWithDataJson",
     *     title="Get Basic Error With Data Json",
     *     description="Get basic error with data json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is error property",
     *         type="boolean",
     *         example=false
     *     ),
     *     @OA\Property(
     *         property="messages",
     *         description="messages property",
     *         type="array",
     *         @OA\Items()
     *     ),
     *     oneOf={
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="object"
     *         ),
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="array",
     *             @OA\Items()
     *         )
     *     }
     * )
     *
     * @param BasicResponse $response
     * @param object $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getErrorWithDataJson(BasicResponse $response, object $data)
    {
        return response()->json([
            'isSuccess' => false,
            'messages' => $response->getMessageResponseErrorTextArray(),
            'data' => $data
        ], $response->getStatus());
    }

    /**
     * @OA\Schema(
     *     schema="GetBasicErrorWithStringDataJson",
     *     title="Get Basic Error With String Data Json",
     *     description="Get basic error with string data json schema",
     *     @OA\Property(
     *         property="isSuccess",
     *         description="is success property",
     *         type="boolean",
     *         example=false
     *     ),
     *     @OA\Property(
     *         property="message",
     *         description="message property",
     *         type="string"
     *     ),
     *     oneOf={
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="object"
     *         ),
     *         @OA\Property(
     *             property="data",
     *             description="data property",
     *             type="array",
     *             @OA\Items()
     *         )
     *     }
     * )
     *
     * @param BasicResponse $response
     * @param string $message
     * @param object $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getErrorWithStringDataJson(BasicResponse $response, string $message, object $data)
    {
        return response()->json([
            'isSuccess' => false,
            'message' => $message,
            'data' => $data
        ], $response->getStatus());
    }



    /**
     * Example:
     * {
     *      "search": null,
     *      "sort": {
     *          "order": "ASC",
     *          "column": "id"
     *      }
     * }
     *
     * @OA\Schema(
     *     schema="ListSearchParameter",
     *     title="List Search Parameter",
     *     description="List search parameter schema",
     *     @OA\Property(
     *         property="search",
     *         description="Search property",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="sort",
     *         description="Sort property",
     *         @OA\Property(
     *             property="order",
     *             description="Order property",
     *             type="string",
     *             example="DESC"
     *         ),
     *         @OA\Property(
     *             property="column",
     *             description="Column property",
     *             type="string",
     *             example="id"
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return ListSearchRequest
     */
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

    /**
     * Example:
     * {
     *      "search": null,
     *      "pagination": {
     *          "page": 1,
     *          "length": 10
     *      },
     *      "sort": {
     *          "order": "ASC",
     *          "column": "id"
     *      }
     * }
     *
     * @OA\Schema(
     *     schema="PageSearchParameter",
     *     title="Page Search Parameter",
     *     description="Page search parameter schema",
     *     @OA\Property(
     *         property="search",
     *         description="Search property",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="pagination",
     *         description="Pagination property",
     *         @OA\Property(
     *             property="page",
     *             description="Page property",
     *             type="integer",
     *             format="int32",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="length",
     *             description="Length property",
     *             type="integer",
     *             format="int32",
     *             example=10
     *         )
     *     ),
     *     @OA\Property(
     *         property="sort",
     *         description="Sort property",
     *         @OA\Property(
     *             property="order",
     *             description="Order property",
     *             type="string",
     *             example="DESC"
     *         ),
     *         @OA\Property(
     *             property="column",
     *             description="Column property",
     *             type="string",
     *             example="id"
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return PageSearchRequest
     */
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

    /**
     * @param Request $request
     * @param callable $dtoCollectionToRowJsonMethod
     * @param callable $searchMethod
     * @param array $arguments
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getListSearchJson(Request $request,
                                             callable $dtoCollectionToRowJsonMethod,
                                             callable $searchMethod,
                                             array $arguments = [])
    {
        $parameter = $this->generateListSearchParameter($request);

        array_unshift($arguments, $parameter);

        $response = call_user_func_array($searchMethod, $arguments);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response);

        return $this->getListSearchJsonResponse($rowJsonData, $response);
    }

    /**
     * @param Request $request
     * @param callable $dtoCollectionToRowJsonMethod
     * @param callable $searchMethod
     * @param array $arguments
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getPageSearchJson(Request $request,
                                             callable $dtoCollectionToRowJsonMethod,
                                             callable $searchMethod,
                                             array $arguments = [])
    {
        $parameter = $this->generatePageSearchParameter($request);

        array_unshift($arguments, $parameter);

        $response = call_user_func_array($searchMethod, $arguments);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response);

        return $this->getPageSearchJsonResponse($rowJsonData, $response, $parameter);
    }

    /**
     * @OA\Schema(
     *     schema="GenericListSearchJsonResponse",
     *     title="Generic List Search Json Response",
     *     description="Generic list search json response schema",
     *     @OA\Property(
     *         property="meta",
     *         description="Meta property",
     *         type="object",
     *         @OA\Property(property="total", type="integer", format="int32")
     *     )
     * )
     *
     * @param Collection $rowJsonData
     * @param GenericListSearchResponse $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getListSearchJsonResponse(Collection $rowJsonData,
                                                 GenericListSearchResponse $response)
    {
        return response()->json([
            'total' => $response->getTotalCount(),
            'rows' => $rowJsonData
        ]);
    }

    /**
     * @OA\Schema(
     *     schema="GenericPageSearchJsonResponse",
     *     title="Generic Page Search Json Response",
     *     description="Generic page search json response schema",
     *     @OA\Property(
     *         property="meta",
     *         description="Meta property",
     *         type="object",
     *         @OA\Property(property="page", type="integer", format="int32"),
     *         @OA\Property(property="length", type="integer", format="int32"),
     *         @OA\Property(property="pages", type="integer", format="int32"),
     *         @OA\Property(property="total", type="integer", format="int32"),
     *         @OA\Property(property="order", type="string", example="column"),
     *         @OA\Property(property="column", type="string", example="ASC")
     *     )
     * )
     *
     * @param Collection $rowJsonData
     * @param GenericPageSearchResponse $response
     * @param PageSearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getPageSearchJsonResponse(Collection $rowJsonData,
                                                     GenericPageSearchResponse $response,
                                                     PageSearchRequest $request)
    {
        return response()->json([
            'meta' => [
                'page' => (integer)$request->pagination['page'],
                'length' => (integer)$request->pagination['length'],
                'pages' => $response->getTotalPage(),
                'total' => $response->getTotalCount(),
                'order' => $request->sort['order'],
                'column' => $request->sort['column']
            ],
            'rows' => $rowJsonData
        ]);
    }



    /**
     * @param object $jsonData
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getDataJsonResponse(object $jsonData)
    {
        return response()->json($jsonData);
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

/**
 * @OA\Schema(
 *     schema="GenericUnauthenticatedJsonResponse",
 *     title="Generic Unauthenticated Json Response",
 *     description="Generic unauthenticated json response schema",
 *     @OA\Property(property="error", type="string"),
 *     @OA\Property(property="error_description", type="string"),
 *     @OA\Property(property="hint", type="string"),
 *     @OA\Property(property="message", type="string")
 * )
 */
