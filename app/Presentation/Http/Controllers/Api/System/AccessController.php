<?php
namespace App\Presentation\Http\Controllers\Api\System;


use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\System\Request\CreateAccessRequest;
use App\Service\Contracts\System\Request\UpdateAccessRequest;
use App\Service\Contracts\System\ISystemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccessController extends ApiBaseController
{
    private ISystemService $_systemService;

    public function __construct(ISystemService $systemService)
    {
        $this->_systemService = $systemService;
    }

    /**
     * @OA\Get(
     *     path="/system/accesses",
     *     operationId="actionGetAccesses",
     *     tags={"System", "Access"},
     *     description="Get accesses",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                      @OA\Schema(ref="#/components/schemas/AccessEloquent")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function actionGetAccesses()
    {
        $getAccessesResponse = $this->_systemService->getAccesses();

        if ($getAccessesResponse->isError()) {
            return $this->getErrorJson($getAccessesResponse);
        }

        return $this->getDataJsonResponse($getAccessesResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/system/accesses/list-search",
     *     operationId="actionAccessesListSearch",
     *     tags={"System", "Access"},
     *     description="Accesses list search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ListSearchParameter")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GenericListSearchJsonResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="rows",
     *                          description="rows property",
     *                          type="array",
     *                          @OA\Items(
     *                              allOf={
     *                                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                                  @OA\Schema(ref="#/components/schemas/AccessEloquent")
     *                              }
     *                          )
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actionGetAccessesListSearch(Request $request)
    {
        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_systemService, 'getAccessesListSearch']);
    }

    /**
     * @OA\Post(
     *     path="/system/accesses/page-search",
     *     operationId="actionAccessesPageSearch",
     *     tags={"System", "Access"},
     *     description="Accesses page search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/PageSearchParameter")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GenericPageSearchJsonResponse"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="rows",
     *                          description="rows property",
     *                          type="array",
     *                          @OA\Items(
     *                              allOf={
     *                                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                                  @OA\Schema(ref="#/components/schemas/AccessEloquent")
     *                              }
     *                          )
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actionGetAccessesPageSearch(Request $request)
    {
        return $this->getPageSearchJson($request,
            function(GenericPageSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_systemService, 'getAccessesPageSearch']);
    }

    /**
     * @OA\Post(
     *     path="/system/access",
     *     operationId="actionCreateAccess",
     *     tags={"System", "Access"},
     *     description="Create access",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateAccessRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/AccessEloquent")
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function actionCreateAccess(Request $request)
    {
        $createAccessRequest = new CreateAccessRequest();

        $createAccessRequest->name = $request->input('name');
        $createAccessRequest->slug = $request->input('slug');
        $createAccessRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($createAccessRequest);

        $createAccessResponse = $this->_systemService->createAccess($createAccessRequest);

        if ($createAccessResponse->isError()) {
            return $this->getErrorJson($createAccessResponse);
        }

        return $this->getBasicSuccessWithDataJson($createAccessResponse, $createAccessResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/system/access/{id}",
     *     operationId="actionShowAccess",
     *     tags={"System", "Access"},
     *     description="Show access",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/AccessEloquent")
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function actionShowAccess(int $id)
    {
        $showAccessResponse = $this->_systemService->showAccess($id);

        if ($showAccessResponse->isError()) {
            return $this->getErrorJson($showAccessResponse);
        }

        return $this->getDataJsonResponse($showAccessResponse->dto);
    }

    /**
     * @OA\Put(
     *     path="/system/access/{id}",
     *     operationId="actionUpdateAccess",
     *     tags={"System", "Access"},
     *     description="Update access",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateAccessRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
     *                  @OA\Schema(ref="#/components/schemas/AccessEloquent")
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function actionUpdateAccess(Request $request, int $id)
    {
        $updateAccessRequest = new UpdateAccessRequest();

        $updateAccessRequest->id = $id;
        $updateAccessRequest->name = $request->input('name');
        $updateAccessRequest->slug = $request->input('slug');
        $updateAccessRequest->description = $request->input('description') ?? null;

        $this->setRequestAuthor($updateAccessRequest);

        $updateAccessResponse = $this->_systemService->updateAccess($updateAccessRequest);

        if ($updateAccessResponse->isError()) {
            return $this->getErrorJson($updateAccessResponse);
        }

        return $this->getBasicSuccessWithDataJson($updateAccessResponse, $updateAccessResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/system/access/{id}",
     *     operationId="actionDestroyAccess",
     *     tags={"System", "Access"},
     *     description="Destroy access",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function actionDestroyAccess(int $id)
    {
        $destroyAccessResponse = $this->_systemService->destroyAccess($id);

        if ($destroyAccessResponse->isError()) {
            return $this->getErrorJson($destroyAccessResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyAccessResponse, "Access deleted: " . $destroyAccessResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/system/accesses",
     *     operationId="actionDestroyAccesses",
     *     tags={"System", "Access"},
     *     description="Destroy accesses",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="ids",
     *                      description="Ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64"
     *                      ),
     *                      example={1,2,3}
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function actionDestroyAccesses(Request $request)
    {
        $ids = $request->input('ids');

        $destroyAccessResponse = $this->_systemService->destroyAccesses($ids);

        if ($destroyAccessResponse->isError()) {
            return $this->getErrorJson($destroyAccessResponse);
        }

        return $this->getBasicSuccessJson($destroyAccessResponse);
    }

    /**
     * @OA\Get(
     *     path="/system/access/slug/{name}",
     *     operationId="getSlugAccess",
     *     tags={"System", "Access"},
     *     description="Return access slug",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param string $name
     * @return JsonResponse
     */
    public function actionGetSlugAccess(string $name)
    {
        $getSlugAccessResponse = $this->_systemService->getSlugAccess($name);

        if ($getSlugAccessResponse->isError()) {
            return $this->getErrorJson($getSlugAccessResponse);
        }

        return $this->getDataJsonResponse($getSlugAccessResponse->dto);
    }
}
