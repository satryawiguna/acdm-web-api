<?php
namespace App\Presentation\Http\Controllers\Api\Element;


use App\Events\Broadcast\SendDepartureEvent;
use App\Events\Broadcast\SendTobtEvent;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Departure\IDepartureService;
use App\Service\Contracts\Element\IElementService;
use App\Service\Contracts\Element\Request\CreateElementRequest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ElementController extends ApiBaseController
{
    private IElementService $_elementService;

    private IDepartureService $_departureService;

    public function __construct(IElementService $elementService, IDepartureService $departureService)
    {
        $this->_elementService = $elementService;

        $this->_departureService = $departureService;
    }

    /**
     * @OA\Get(
     *     path="/element/{departureId}/acgts",
     *     operationId="actionGetAcgts",
     *     tags={"Element","ACGT"},
     *     description="Get acgts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AcgtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAcgts(int $departureId)
    {
        $getAcgtsResponse = $this->_elementService->getAcgts($departureId);

        if ($getAcgtsResponse->isError()) {
            return $this->getErrorJson($getAcgtsResponse);
        }

        return $this->getDataJsonResponse($getAcgtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/acgt",
     *     operationId="actionCreateAcgt",
     *     tags={"Element","ACGT"},
     *     description="Create acgt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AcgtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AcgtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAcgt(Request $request)
    {
        $createAcgtRequest = new CreateElementRequest();

        $createAcgtRequest->departure_id = (int)$request->input('departure_id');
        $createAcgtRequest->acgt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('acgt'))) ? new DateTime($request->input('acgt')) : null;
        $createAcgtRequest->reason = (string)$request->input('reason');
        $createAcgtRequest->init = (bool)$request->input('init');
        $createAcgtRequest->acgtable_id = (int)$request->input('acgtable_id');
        $createAcgtRequest->acgtable_type = $request->input('acgtable_type');

        $this->setRequestAuthor($createAcgtRequest);

        $createAcgtResponse = $this->_elementService->createAcgt($createAcgtRequest);

        if ($createAcgtResponse->isError()) {
            return $this->getErrorJson($createAcgtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAcgtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAcgtResponse, $createAcgtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/aczts",
     *     operationId="actionGetAczts",
     *     tags={"Element","ACZT"},
     *     description="Get aczts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AcztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAczts(int $departureId)
    {
        $getAcztsResponse = $this->_elementService->getAczts($departureId);

        if ($getAcztsResponse->isError()) {
            return $this->getErrorJson($getAcztsResponse);
        }

        return $this->getDataJsonResponse($getAcztsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/aczt",
     *     operationId="actionCreateAczt",
     *     tags={"Element","ACZT"},
     *     description="Create aczt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AcztCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AcztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAczt(Request $request)
    {
        $createAcztRequest = new CreateElementRequest();

        $createAcztRequest->departure_id = (int)$request->input('departure_id');
        $createAcztRequest->aczt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('aczt'))) ? new DateTime($request->input('aczt')) : null;
        $createAcztRequest->reason = (string)$request->input('reason');
        $createAcztRequest->init = (bool)$request->input('init');
        $createAcztRequest->acztable_id = (int)$request->input('acztable_id');
        $createAcztRequest->acztable_type = $request->input('acztable_type');

        $this->setRequestAuthor($createAcztRequest);

        $createAcztResponse = $this->_elementService->createAczt($createAcztRequest);

        if ($createAcztResponse->isError()) {
            return $this->getErrorJson($createAcztResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAcztResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAcztResponse, $createAcztResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/adits",
     *     operationId="actionGetAdits",
     *     tags={"Element","ADIT"},
     *     description="Get adits",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AditEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAdits(int $departureId)
    {
        $getAditsResponse = $this->_elementService->getAdits($departureId);

        if ($getAditsResponse->isError()) {
            return $this->getErrorJson($getAditsResponse);
        }

        return $this->getDataJsonResponse($getAditsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/adit",
     *     operationId="actionCreateAdit",
     *     tags={"Element","ADIT"},
     *     description="Create adit",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AditCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AditEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAdit(Request $request)
    {
        $createAditRequest = new CreateElementRequest();

        $createAditRequest->departure_id = (int)$request->input('departure_id');
        $createAditRequest->adit = (int)$request->input('adit');
        $createAditRequest->reason = (string)$request->input('reason');
        $createAditRequest->init = (bool)$request->input('init');
        $createAditRequest->aditable_id = (int)$request->input('aditable_id');
        $createAditRequest->aditable_type = $request->input('aditable_type');

        $this->setRequestAuthor($createAditRequest);

        $createAditResponse = $this->_elementService->createAdit($createAditRequest);

        if ($createAditResponse->isError()) {
            return $this->getErrorJson($createAditResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAditResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAditResponse, $createAditResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/aegts",
     *     operationId="actionGetAegts",
     *     tags={"Element","AEGT"},
     *     description="Get aegts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AegtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAegts(int $departureId)
    {
        $getAegtsResponse = $this->_elementService->getAegts($departureId);

        if ($getAegtsResponse->isError()) {
            return $this->getErrorJson($getAegtsResponse);
        }

        return $this->getDataJsonResponse($getAegtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/aegt",
     *     operationId="actionCreateAegt",
     *     tags={"Element","AEGT"},
     *     description="Create aegt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AegtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AegtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAegt(Request $request)
    {
        $createAegtRequest = new CreateElementRequest();

        $createAegtRequest->departure_id = (int)$request->input('departure_id');
        $createAegtRequest->aegt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('aegt'))) ? new DateTime($request->input('aegt')) : null;
        $createAegtRequest->reason = (string)$request->input('reason');
        $createAegtRequest->init = (bool)$request->input('init');
        $createAegtRequest->aegtable_id = (int)$request->input('aegtable_id');
        $createAegtRequest->aegtable_type = $request->input('aegtable_type');

        $this->setRequestAuthor($createAegtRequest);

        $createAegtResponse = $this->_elementService->createAegt($createAegtRequest);

        if ($createAegtResponse->isError()) {
            return $this->getErrorJson($createAegtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAegtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAegtResponse, $createAegtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/aezts",
     *     operationId="actionGetAezts",
     *     tags={"Element","AEZT"},
     *     description="Get aezts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AeztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAezts(int $departureId)
    {
        $getAeztsResponse = $this->_elementService->getAezts($departureId);

        if ($getAeztsResponse->isError()) {
            return $this->getErrorJson($getAeztsResponse);
        }

        return $this->getDataJsonResponse($getAeztsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/aezt",
     *     operationId="actionCreateAezt",
     *     tags={"Element","AEZT"},
     *     description="Create aezt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AeztCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AeztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAezt(Request $request)
    {
        $createAeztRequest = new CreateElementRequest();

        $createAeztRequest->departure_id = (int)$request->input('departure_id');
        $createAeztRequest->aezt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('aezt'))) ? new DateTime($request->input('aezt')) : null;
        $createAeztRequest->reason = (string)$request->input('reason');
        $createAeztRequest->init = (bool)$request->input('init');
        $createAeztRequest->aeztable_id = (int)$request->input('aeztable_id');
        $createAeztRequest->aeztable_type = $request->input('aeztable_type');

        $this->setRequestAuthor($createAeztRequest);

        $createAeztResponse = $this->_elementService->createAezt($createAeztRequest);

        if ($createAeztResponse->isError()) {
            return $this->getErrorJson($createAeztResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAeztResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAeztResponse, $createAeztResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/aghts",
     *     operationId="actionGetAghts",
     *     tags={"Element","AGHT"},
     *     description="Get aghts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AghtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAghts(int $departureId)
    {
        $getAghtsResponse = $this->_elementService->getAghts($departureId);

        if ($getAghtsResponse->isError()) {
            return $this->getErrorJson($getAghtsResponse);
        }

        return $this->getDataJsonResponse($getAghtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/aght",
     *     operationId="actionCreateAght",
     *     tags={"Element","AGHT"},
     *     description="Create aght",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AghtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AghtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAght(Request $request)
    {
        $createAghtRequest = new CreateElementRequest();

        $createAghtRequest->departure_id = (int)$request->input('departure_id');
        $createAghtRequest->aght = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('aght'))) ? new DateTime($request->input('aght')) : null;
        $createAghtRequest->reason = (string)$request->input('reason');
        $createAghtRequest->init = (bool)$request->input('init');
        $createAghtRequest->aghtable_id = (int)$request->input('aghtable_id');
        $createAghtRequest->aghtable_type = $request->input('aghtable_type');

        $this->setRequestAuthor($createAghtRequest);

        $createAghtResponse = $this->_elementService->createAght($createAghtRequest);

        if ($createAghtResponse->isError()) {
            return $this->getErrorJson($createAghtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAghtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAghtResponse, $createAghtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/aobts",
     *     operationId="actionGetAobts",
     *     tags={"Element","AOBT"},
     *     description="Get aobts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAobts(int $departureId)
    {
        $getAobtsResponse = $this->_elementService->getAobts($departureId);

        if ($getAobtsResponse->isError()) {
            return $this->getErrorJson($getAobtsResponse);
        }

        return $this->getDataJsonResponse($getAobtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/aobt",
     *     operationId="actionCreateAobt",
     *     tags={"Element","AOBT"},
     *     description="Create aobt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AobtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAobt(Request $request)
    {
        $createAobtRequest = new CreateElementRequest();

        $createAobtRequest->departure_id = (int)$request->input('departure_id');
        $createAobtRequest->aobt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('aobt'))) ? new DateTime($request->input('aobt')) : null;
        $createAobtRequest->reason = (string)$request->input('reason');
        $createAobtRequest->init = (bool)$request->input('init');
        $createAobtRequest->aobtable_id = (int)$request->input('aobtable_id');
        $createAobtRequest->aobtable_type = $request->input('aobtable_type');

        $this->setRequestAuthor($createAobtRequest);

        $createAobtResponse = $this->_elementService->createAobt($createAobtRequest);

        if ($createAobtResponse->isError()) {
            return $this->getErrorJson($createAobtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAobtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAobtResponse, $createAobtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/ardts",
     *     operationId="actionGetArdts",
     *     tags={"Element","ARDT"},
     *     description="Get ardts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ArdtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetArdts(int $departureId)
    {
        $getArdtsResponse = $this->_elementService->getArdts($departureId);

        if ($getArdtsResponse->isError()) {
            return $this->getErrorJson($getArdtsResponse);
        }

        return $this->getDataJsonResponse($getArdtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/ardt",
     *     operationId="actionCreateArdt",
     *     tags={"Element","ARDT"},
     *     description="Create ardt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/ArdtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ArdtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateArdt(Request $request)
    {
        $createArdtRequest = new CreateElementRequest();

        $createArdtRequest->departure_id = (int)$request->input('departure_id');
        $createArdtRequest->ardt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('ardt'))) ? new DateTime($request->input('ardt')) : null;
        $createArdtRequest->reason = (string)$request->input('reason');
        $createArdtRequest->init = (bool)$request->input('init');
        $createArdtRequest->ardtable_id = (int)$request->input('ardtable_id');
        $createArdtRequest->ardtable_type = $request->input('ardtable_type');

        $this->setRequestAuthor($createArdtRequest);

        $createArdtResponse = $this->_elementService->createArdt($createArdtRequest);

        if ($createArdtResponse->isError()) {
            return $this->getErrorJson($createArdtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createArdtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createArdtResponse, $createArdtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/arzts",
     *     operationId="actionGetArzts",
     *     tags={"Element","ARZT"},
     *     description="Get arzts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ArztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetArzts(int $departureId)
    {
        $getArztsResponse = $this->_elementService->getArzts($departureId);

        if ($getArztsResponse->isError()) {
            return $this->getErrorJson($getArztsResponse);
        }

        return $this->getDataJsonResponse($getArztsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/arzt",
     *     operationId="actionCreateArzt",
     *     tags={"Element","ARZT"},
     *     description="Create arzt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/ArztCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ArztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateArzt(Request $request)
    {
        $createArztRequest = new CreateElementRequest();

        $createArztRequest->departure_id = (int)$request->input('departure_id');
        $createArztRequest->arzt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('arzt'))) ? new DateTime($request->input('arzt')) : null;
        $createArztRequest->reason = (string)$request->input('reason');
        $createArztRequest->init = (bool)$request->input('init');
        $createArztRequest->arztable_id = (int)$request->input('arztable_id');
        $createArztRequest->arztable_type = (int)$request->input('arztable_type');

        $this->setRequestAuthor($createArztRequest);

        $createArztResponse = $this->_elementService->createArzt($createArztRequest);

        if ($createArztResponse->isError()) {
            return $this->getErrorJson($createArztResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createArztResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createArztResponse, $createArztResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/asbts",
     *     operationId="actionGetAsbts",
     *     tags={"Element","ASBT"},
     *     description="Get asbts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AsbtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAsbts(int $departureId)
    {
        $getAsbtsResponse = $this->_elementService->getAsbts($departureId);

        if ($getAsbtsResponse->isError()) {
            return $this->getErrorJson($getAsbtsResponse);
        }

        return $this->getDataJsonResponse($getAsbtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/asbt",
     *     operationId="actionCreateAsbt",
     *     tags={"Element","ASBT"},
     *     description="Create asbt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AsbtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AsbtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAsbt(Request $request)
    {
        $createAsbtRequest = new CreateElementRequest();

        $createAsbtRequest->departure_id = (int)$request->input('departure_id');
        $createAsbtRequest->asbt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('asbt'))) ? new DateTime($request->input('asbt')) : null;
        $createAsbtRequest->reason = (string)$request->input('reason');
        $createAsbtRequest->init = (bool)$request->input('init');
        $createAsbtRequest->asbtable_id = (int)$request->input('asbtable_id');
        $createAsbtRequest->asbtable_type = $request->input('asbtable_type');

        $this->setRequestAuthor($createAsbtRequest);

        $createAsbtResponse = $this->_elementService->createAsbt($createAsbtRequest);

        if ($createAsbtResponse->isError()) {
            return $this->getErrorJson($createAsbtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAsbtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAsbtResponse, $createAsbtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/asrts",
     *     operationId="actionGetAsrts",
     *     tags={"Element","ASRT"},
     *     description="Get asrts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AsrtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAsrts(int $departureId)
    {
        $getAsrtsResponse = $this->_elementService->getAsrts($departureId);

        if ($getAsrtsResponse->isError()) {
            return $this->getErrorJson($getAsrtsResponse);
        }

        return $this->getDataJsonResponse($getAsrtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/asrt",
     *     operationId="actionCreateAsrt",
     *     tags={"Element","ASRT"},
     *     description="Create asrt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AsrtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AsrtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAsrt(Request $request)
    {
        $createAsrtRequest = new CreateElementRequest();

        $createAsrtRequest->departure_id = (int)$request->input('departure_id');
        $createAsrtRequest->asrt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('asrt'))) ? new DateTime($request->input('asrt')) : null;
        $createAsrtRequest->reason = (string)$request->input('reason');
        $createAsrtRequest->init = (bool)$request->input('init');
        $createAsrtRequest->asrtable_id = (int)$request->input('asrtable_id');
        $createAsrtRequest->asrtable_type = $request->input('asrtable_type');

        $this->setRequestAuthor($createAsrtRequest);

        $createAsrtResponse = $this->_elementService->createAsrt($createAsrtRequest);

        if ($createAsrtResponse->isError()) {
            return $this->getErrorJson($createAsrtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAsrtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAsrtResponse, $createAsrtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/atets",
     *     operationId="actionGetAtets",
     *     tags={"Element","ATET"},
     *     description="Get atets",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtetEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAtets(int $departureId)
    {
        $getAtetsResponse = $this->_elementService->getAtets($departureId);

        if ($getAtetsResponse->isError()) {
            return $this->getErrorJson($getAtetsResponse);
        }

        return $this->getDataJsonResponse($getAtetsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/atet",
     *     operationId="actionCreateAtet",
     *     tags={"Element","ATET"},
     *     description="Create atet",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AtetCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtetEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAtet(Request $request)
    {
        $createAtetRequest = new CreateElementRequest();

        $createAtetRequest->departure_id = (int)$request->input('departure_id');
        $createAtetRequest->atet = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('atet'))) ? new DateTime($request->input('atet')) : null;
        $createAtetRequest->reason = (string)$request->input('reason');
        $createAtetRequest->init = (bool)$request->input('init');
        $createAtetRequest->atetable_id = (int)$request->input('atetable_id');
        $createAtetRequest->atetable_type = $request->input('atetable_type');

        $this->setRequestAuthor($createAtetRequest);

        $createAtetResponse = $this->_elementService->createAtet($createAtetRequest);

        if ($createAtetResponse->isError()) {
            return $this->getErrorJson($createAtetResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAtetResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAtetResponse, $createAtetResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/atots",
     *     operationId="actionGetAtots",
     *     tags={"Element","ATOT"},
     *     description="Get atots",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAtots(int $departureId)
    {
        $getAtotsResponse = $this->_elementService->getAtots($departureId);

        if ($getAtotsResponse->isError()) {
            return $this->getErrorJson($getAtotsResponse);
        }

        return $this->getDataJsonResponse($getAtotsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/atot",
     *     operationId="actionCreateAtot",
     *     tags={"Element","ATOT"},
     *     description="Create atot",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AtotCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAtot(Request $request)
    {
        $createAtotRequest = new CreateElementRequest();

        $createAtotRequest->departure_id = (int)$request->input('departure_id');
        $createAtotRequest->atot = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('atot'))) ? new DateTime($request->input('atot')) : null;
        $createAtotRequest->reason = (string)$request->input('reason');
        $createAtotRequest->init = (bool)$request->input('init');
        $createAtotRequest->atotable_id = (int)$request->input('atotable_id');
        $createAtotRequest->atotable_type= $request->input('atotable_type');

        $this->setRequestAuthor($createAtotRequest);

        $createAtotResponse = $this->_elementService->createAtot($createAtotRequest);

        if ($createAtotResponse->isError()) {
            return $this->getErrorJson($createAtotResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAtotResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAtotResponse, $createAtotResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/atsts",
     *     operationId="actionGetAtsts",
     *     tags={"Element","ATST"},
     *     description="Get atsts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtstEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAtsts(int $departureId)
    {
        $getAtstsResponse = $this->_elementService->getAtsts($departureId);

        if ($getAtstsResponse->isError()) {
            return $this->getErrorJson($getAtstsResponse);
        }

        return $this->getDataJsonResponse($getAtstsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/atst",
     *     operationId="actionCreateAtst",
     *     tags={"Element","ATST"},
     *     description="Create atst",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AtstCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtstEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAtst(Request $request)
    {
        $createAtstRequest = new CreateElementRequest();

        $createAtstRequest->departure_id = (int)$request->input('departure_id');
        $createAtstRequest->atst = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('atst'))) ? new DateTime($request->input('atst')) : null;
        $createAtstRequest->reason = (string)$request->input('reason');
        $createAtstRequest->init = (bool)$request->input('init');
        $createAtstRequest->atotable_id = (int)$request->input('atotable_id');
        $createAtstRequest->atotable_type = $request->input('atotable_type');

        $this->setRequestAuthor($createAtstRequest);

        $createAtstResponse = $this->_elementService->createAtst($createAtstRequest);

        if ($createAtstResponse->isError()) {
            return $this->getErrorJson($createAtstResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAtstResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAtstResponse, $createAtstResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/attts",
     *     operationId="actionGetAttts",
     *     tags={"Element","ATTT"},
     *     description="Get attts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtttEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAttts(int $departureId)
    {
        $getAtttsResponse = $this->_elementService->getAttts($departureId);

        if ($getAtttsResponse->isError()) {
            return $this->getErrorJson($getAtttsResponse);
        }

        return $this->getDataJsonResponse($getAtttsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/attt",
     *     operationId="actionCreateAttt",
     *     tags={"Element","ATTT"},
     *     description="Create attt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AtttCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AtttEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAttt(Request $request)
    {
        $createAtttRequest = new CreateElementRequest();

        $createAtttRequest->departure_id = (int)$request->input('departure_id');
        $createAtttRequest->attt = (int)$request->input('attt');
        $createAtttRequest->reason = (string)$request->input('reason');
        $createAtttRequest->init = (bool)$request->input('init');
        $createAtttRequest->atttable_id = (int)$request->input('atttable_id');
        $createAtttRequest->atttable_type = $request->input('atttable_type');

        $this->setRequestAuthor($createAtttRequest);

        $createAtttResponse = $this->_elementService->createAttt($createAtttRequest);

        if ($createAtttResponse->isError()) {
            return $this->getErrorJson($createAtttResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAtttResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAtttResponse, $createAtttResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/axots",
     *     operationId="actionGetAxots",
     *     tags={"Element","AXOT"},
     *     description="Get axots",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AxotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAxots(int $departureId)
    {
        $getAxotsResponse = $this->_elementService->getAxots($departureId);

        if ($getAxotsResponse->isError()) {
            return $this->getErrorJson($getAxotsResponse);
        }

        return $this->getDataJsonResponse($getAxotsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/axot",
     *     operationId="actionCreateAxot",
     *     tags={"Element","AXOT"},
     *     description="Create axot",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AxotCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AxotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAxot(Request $request)
    {
        $createAxotRequest = new CreateElementRequest();

        $createAxotRequest->departure_id = (int)$request->input('departure_id');
        $createAxotRequest->axot = (int)$request->input('axot');
        $createAxotRequest->reason = (string)$request->input('reason');
        $createAxotRequest->init = (bool)$request->input('init');
        $createAxotRequest->axotable_id = (int)$request->input('axotable_id');
        $createAxotRequest->axotable_type = $request->input('axotable_type');

        $this->setRequestAuthor($createAxotRequest);

        $createAxotResponse = $this->_elementService->createAxot($createAxotRequest);

        if ($createAxotResponse->isError()) {
            return $this->getErrorJson($createAxotResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAxotResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAxotResponse, $createAxotResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/azats",
     *     operationId="actionGetAzats",
     *     tags={"Element","AZAT"},
     *     description="Get azats",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AzatEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetAzats(int $departureId)
    {
        $getAzatsResponse = $this->_elementService->getAzats($departureId);

        if ($getAzatsResponse->isError()) {
            return $this->getErrorJson($getAzatsResponse);
        }

        return $this->getDataJsonResponse($getAzatsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/azat",
     *     operationId="actionCreateAzat",
     *     tags={"Element","AZAT"},
     *     description="Create azat",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/AzatCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/AzatEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateAzat(Request $request)
    {
        $createAzatRequest = new CreateElementRequest();

        $createAzatRequest->departure_id = (int)$request->input('departure_id');
        $createAzatRequest->azat = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('azat'))) ? new DateTime($request->input('azat')) : null;
        $createAzatRequest->reason = (string)$request->input('reason');
        $createAzatRequest->init = (bool)$request->input('init');
        $createAzatRequest->azatable_id = (int)$request->input('azatable_id');
        $createAzatRequest->azatable_type = $request->input('azatable_type');

        $this->setRequestAuthor($createAzatRequest);

        $createAzatResponse = $this->_elementService->createAzat($createAzatRequest);

        if ($createAzatResponse->isError()) {
            return $this->getErrorJson($createAzatResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createAzatResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createAzatResponse, $createAzatResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/ctots",
     *     operationId="actionGetCtots",
     *     tags={"Element","CTOT"},
     *     description="Get ctots",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/CtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetCtots(int $departureId)
    {
        $getCtotsResponse = $this->_elementService->getCtots($departureId);

        if ($getCtotsResponse->isError()) {
            return $this->getErrorJson($getCtotsResponse);
        }

        return $this->getDataJsonResponse($getCtotsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/ctot",
     *     operationId="actionCreateCtot",
     *     tags={"Element","CTOT"},
     *     description="Create ctot",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/CtotCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/CtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateCtot(Request $request)
    {
        $createCtotRequest = new CreateElementRequest();

        $createCtotRequest->departure_id = (int)$request->input('departure_id');
        $createCtotRequest->ctot = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('ctot'))) ? new DateTime($request->input('ctot')) : null;
        $createCtotRequest->reason = (string)$request->input('reason');
        $createCtotRequest->init = (bool)$request->input('init');
        $createCtotRequest->ctotable_id = (int)$request->input('ctotable_id');
        $createCtotRequest->ctotable_type = $request->input('ctotable_type');

        $this->setRequestAuthor($createCtotRequest);

        $createCtotResponse = $this->_elementService->createCtot($createCtotRequest);

        if ($createCtotResponse->isError()) {
            return $this->getErrorJson($createCtotResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createCtotResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createCtotResponse, $createCtotResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/eczts",
     *     operationId="actionGetEczts",
     *     tags={"Element","ECZT"},
     *     description="Get eczts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EcztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetEczts(int $departureId)
    {
        $getEcztsResponse = $this->_elementService->getEczts($departureId);

        if ($getEcztsResponse->isError()) {
            return $this->getErrorJson($getEcztsResponse);
        }

        return $this->getDataJsonResponse($getEcztsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/eczt",
     *     operationId="actionCreateEczt",
     *     tags={"Element","ECZT"},
     *     description="Create eczt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/EcztCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EcztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateEczt(Request $request)
    {
        $createEcztRequest = new CreateElementRequest();

        $createEcztRequest->departure_id = (int)$request->input('departure_id');
        $createEcztRequest->eczt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('eczt'))) ? new DateTime($request->input('eczt')) : null;
        $createEcztRequest->reason = (string)$request->input('reason');
        $createEcztRequest->init = (bool)$request->input('init');
        $createEcztRequest->ecztable_id = (int)$request->input('ecztable_id');
        $createEcztRequest->ecztable_type = $request->input('ecztable_type');

        $this->setRequestAuthor($createEcztRequest);

        $createEcztResponse = $this->_elementService->createEczt($createEcztRequest);

        if ($createEcztResponse->isError()) {
            return $this->getErrorJson($createEcztResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createEcztResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createEcztResponse, $createEcztResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/edits",
     *     operationId="actionGetEdits",
     *     tags={"Element","EDIT"},
     *     description="Get edits",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EditEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetEdits(int $departureId)
    {
        $getEditsResponse = $this->_elementService->getEdits($departureId);

        if ($getEditsResponse->isError()) {
            return $this->getErrorJson($getEditsResponse);
        }

        return $this->getDataJsonResponse($getEditsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/edit",
     *     operationId="actionCreateEdit",
     *     tags={"Element","EDIT"},
     *     description="Create edit",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/EditCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EditEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateEdit(Request $request)
    {
        $createEditRequest = new CreateElementRequest();

        $createEditRequest->departure_id = (int)$request->input('departure_id');
        $createEditRequest->edit = (int)$request->input('edit');
        $createEditRequest->reason = (string)$request->input('reason');
        $createEditRequest->init = (bool)$request->input('init');
        $createEditRequest->editable_id = (int)$request->input('editable_id');
        $createEditRequest->editable_type = $request->input('editable_type');

        $this->setRequestAuthor($createEditRequest);

        $createEditResponse = $this->_elementService->createAzat($createEditRequest);

        if ($createEditResponse->isError()) {
            return $this->getErrorJson($createEditResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createEditResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createEditResponse, $createEditResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/eezts",
     *     operationId="actionGetEezts",
     *     tags={"Element","EEZT"},
     *     description="Get eezts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EeztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetEezts(int $departureId)
    {
        $getEeztsResponse = $this->_elementService->getEezts($departureId);

        if ($getEeztsResponse->isError()) {
            return $this->getErrorJson($getEeztsResponse);
        }

        return $this->getDataJsonResponse($getEeztsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/eezt",
     *     operationId="actionCreateEezt",
     *     tags={"Element","EEZT"},
     *     description="Create eezt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/EeztCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EeztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateEezt(Request $request)
    {
        $createEeztRequest = new CreateElementRequest();

        $createEeztRequest->departure_id = (int)$request->input('departure_id');
        $createEeztRequest->eezt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('eezt'))) ? new DateTime($request->input('eezt')) : null;
        $createEeztRequest->reason = (string)$request->input('reason');
        $createEeztRequest->init = (bool)$request->input('init');
        $createEeztRequest->eeztable_id = (int)$request->input('eeztable_id');
        $createEeztRequest->eeztable_type = $request->input('eeztable_type');

        $this->setRequestAuthor($createEeztRequest);

        $createEeztResponse = $this->_elementService->createEezt($createEeztRequest);

        if ($createEeztResponse->isError()) {
            return $this->getErrorJson($createEeztResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createEeztResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createEeztResponse, $createEeztResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/eobt",
     *     operationId="actionGetEobts",
     *     tags={"Element","EOBT"},
     *     description="Get eobts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetEobts(int $departureId)
    {
        $getEobtsResponse = $this->_elementService->getEobts($departureId);

        if ($getEobtsResponse->isError()) {
            return $this->getErrorJson($getEobtsResponse);
        }

        return $this->getDataJsonResponse($getEobtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/eobt",
     *     operationId="actionCreateEobt",
     *     tags={"Element","EOBT"},
     *     description="Create eobt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/EobtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateEobt(Request $request)
    {
        $createEobtRequest = new CreateElementRequest();

        $createEobtRequest->departure_id = (int)$request->input('departure_id');
        $createEobtRequest->eobt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('eobt'))) ? new DateTime($request->input('eobt')) : null;
        $createEobtRequest->reason = (string)$request->input('reason');
        $createEobtRequest->init = (bool)$request->input('init');
        $createEobtRequest->eobtable_id = (int)$request->input('eobtable_id');
        $createEobtRequest->eobtable_type = $request->input('eobtable_type');

        $this->setRequestAuthor($createEobtRequest);

        $createEobtResponse = $this->_elementService->createEobt($createEobtRequest);

        if ($createEobtResponse->isError()) {
            return $this->getErrorJson($createEobtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createEobtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createEobtResponse, $createEobtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/erzt",
     *     operationId="actionGetErzts",
     *     tags={"Element","ERZT"},
     *     description="Get erzts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ErztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetErzts(int $departureId)
    {
        $getErztsResponse = $this->_elementService->getErzts($departureId);

        if ($getErztsResponse->isError()) {
            return $this->getErrorJson($getErztsResponse);
        }

        return $this->getDataJsonResponse($getErztsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/erzt",
     *     operationId="actionCreateErzt",
     *     tags={"Element","ERZT"},
     *     description="Create erzt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/ErztCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ErztEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateErzt(Request $request)
    {
        $createErztRequest = new CreateElementRequest();

        $createErztRequest->departure_id = (int)$request->input('departure_id');
        $createErztRequest->erzt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('erzt'))) ? new DateTime($request->input('erzt')) : null;
        $createErztRequest->reason = (string)$request->input('reason');
        $createErztRequest->init = (bool)$request->input('init');
        $createErztRequest->erztable_id = (int)$request->input('erztable_id');
        $createErztRequest->erztable_type = (int)$request->input('erztable_type');

        $this->setRequestAuthor($createErztRequest);

        $createErztResponse = $this->_elementService->createErzt($createErztRequest);

        if ($createErztResponse->isError()) {
            return $this->getErrorJson($createErztResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createErztResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createErztResponse, $createErztResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/etots",
     *     operationId="actionGetEtots",
     *     tags={"Element","ETOT"},
     *     description="Get etots",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetEtots(int $departureId)
    {
        $getEtotsResponse = $this->_elementService->getEtots($departureId);

        if ($getEtotsResponse->isError()) {
            return $this->getErrorJson($getEtotsResponse);
        }

        return $this->getDataJsonResponse($getEtotsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/etot",
     *     operationId="actionCreateEtot",
     *     tags={"Element","ETOT"},
     *     description="Create etot",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/EtotCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/EtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateEtot(Request $request)
    {
        $createEtotRequest = new CreateElementRequest();

        $createEtotRequest->departure_id = (int)$request->input('departure_id');
        $createEtotRequest->etot = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('etot'))) ? new DateTime($request->input('etot')) : null;
        $createEtotRequest->reason = (string)$request->input('reason');
        $createEtotRequest->init = (bool)$request->input('init');
        $createEtotRequest->etotable_id = (int)$request->input('etotable_id');
        $createEtotRequest->etotable_type = $request->input('etotable_type');

        $this->setRequestAuthor($createEtotRequest);

        $createEtotResponse = $this->_elementService->createEtot($createEtotRequest);

        if ($createEtotResponse->isError()) {
            return $this->getErrorJson($createEtotResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createEtotResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createEtotResponse, $createEtotResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/exots",
     *     operationId="actionGetExots",
     *     tags={"Element","EXOT"},
     *     description="Get exots",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ExotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetExots(int $departureId)
    {
        $getExotsResponse = $this->_elementService->getExots($departureId);

        if ($getExotsResponse->isError()) {
            return $this->getErrorJson($getExotsResponse);
        }

        return $this->getDataJsonResponse($getExotsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/exot",
     *     operationId="actionCreateExot",
     *     tags={"Element","EXOT"},
     *     description="Create exot",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/ExotCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ExotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateExot(Request $request)
    {
        $createExotRequest = new CreateElementRequest();

        $createExotRequest->departure_id = (int)$request->input('departure_id');
        $createExotRequest->exot = (int)$request->input('exot');
        $createExotRequest->reason = (string)$request->input('reason');
        $createExotRequest->init = (bool)$request->input('init');
        $createExotRequest->exotable_id = (int)$request->input('exotable_id');
        $createExotRequest->exotable_type = $request->input('exotable_type');

        $this->setRequestAuthor($createExotRequest);

        $createExotResponse = $this->_elementService->createExot($createExotRequest);

        if ($createExotResponse->isError()) {
            return $this->getErrorJson($createExotResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createExotResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createExotResponse, $createExotResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/sobts",
     *     operationId="actionGetSobts",
     *     tags={"Element","SOBT"},
     *     description="Get sobts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/SobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetSobts(int $departureId)
    {
        $getSobtsResponse = $this->_elementService->getSobts($departureId);

        if ($getSobtsResponse->isError()) {
            return $this->getErrorJson($getSobtsResponse);
        }

        return $this->getDataJsonResponse($getSobtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/sobt",
     *     operationId="actionCreateSobt",
     *     tags={"Element","SOBT"},
     *     description="Create sobt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/SobtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/SobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateSobt(Request $request)
    {
        $createSobtRequest = new CreateElementRequest();

        $createSobtRequest->departure_id = (int)$request->input('departure_id');
        $createSobtRequest->sobt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('sobt'))) ? new DateTime($request->input('sobt')) : null;
        $createSobtRequest->reason = (string)$request->input('reason');
        $createSobtRequest->init = (bool)$request->input('init');
        $createSobtRequest->sobtable_id = (int)$request->input('sobtable_id');
        $createSobtRequest->sobtable_type = $request->input('sobtable_type');

        $this->setRequestAuthor($createSobtRequest);

        $createSobtResponse = $this->_elementService->createSobt($createSobtRequest);

        if ($createSobtResponse->isError()) {
            return $this->getErrorJson($createSobtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createSobtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createSobtResponse, $createSobtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/stets",
     *     operationId="actionGetStets",
     *     tags={"Element","STET"},
     *     description="Get stets",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/StetEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetStets(int $departureId)
    {
        $getStetsResponse = $this->_elementService->getStets($departureId);

        if ($getStetsResponse->isError()) {
            return $this->getErrorJson($getStetsResponse);
        }

        return $this->getDataJsonResponse($getStetsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/stet",
     *     operationId="actionCreateStet",
     *     tags={"Element","STET"},
     *     description="Create stet",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/StetCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/StetEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateStet(Request $request)
    {
        $createStetRequest = new CreateElementRequest();

        $createStetRequest->departure_id = (int)$request->input('departure_id');
        $createStetRequest->stet = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('stet'))) ? new DateTime($request->input('stet')) : null;
        $createStetRequest->reason = (string)$request->input('reason');
        $createStetRequest->init = (bool)$request->input('init');
        $createStetRequest->stetable_id = (int)$request->input('stetable_id');
        $createStetRequest->stetable_type = $request->input('stetable_type');

        $this->setRequestAuthor($createStetRequest);

        $createStetResponse = $this->_elementService->createStet($createStetRequest);

        if ($createStetResponse->isError()) {
            return $this->getErrorJson($createStetResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createStetResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createStetResponse, $createStetResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/ststs",
     *     operationId="actionGetStsts",
     *     tags={"Element","STST"},
     *     description="Get ststs",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/StstEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetStsts(int $departureId)
    {
        $getStstsResponse = $this->_elementService->getStsts($departureId);

        if ($getStstsResponse->isError()) {
            return $this->getErrorJson($getStstsResponse);
        }

        return $this->getDataJsonResponse($getStstsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/stst",
     *     operationId="actionCreateStst",
     *     tags={"Element","STST"},
     *     description="Create stst",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/StstCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/StstEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateStst(Request $request)
    {
        $createStstRequest = new CreateElementRequest();

        $createStstRequest->departure_id = (int)$request->input('departure_id');
        $createStstRequest->stst = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('stst'))) ? new DateTime($request->input('stst')) : null;
        $createStstRequest->reason = (string)$request->input('reason');
        $createStstRequest->init = (bool)$request->input('init');
        $createStstRequest->ststable_id = (int)$request->input('ststable_id');
        $createStstRequest->ststable_type = $request->input('ststable_type');

        $this->setRequestAuthor($createStstRequest);

        $createStstResponse = $this->_elementService->createStst($createStstRequest);

        if ($createStstResponse->isError()) {
            return $this->getErrorJson($createStstResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createStstResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createStstResponse, $createStstResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/tobts",
     *     operationId="actionGetTobts",
     *     tags={"Element","TOBT"},
     *     description="Get tobts",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetTobts(int $departureId)
    {
        $getTobtsResponse = $this->_elementService->getTobts($departureId);

        if ($getTobtsResponse->isError()) {
            return $this->getErrorJson($getTobtsResponse);
        }

        return $this->getDataJsonResponse($getTobtsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/tobt",
     *     operationId="actionCreateTobt",
     *     tags={"Element","TOBT"},
     *     description="Create tobt",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/TobtCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TobtEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateTobt(Request $request)
    {
        $createTobtRequest = new CreateElementRequest();

        $createTobtRequest->departure_id = (int)$request->input('departure_id');
        $createTobtRequest->tobt = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('tobt'))) ? new DateTime($request->input('tobt')) : null;
        $createTobtRequest->reason = (string)$request->input('reason');
        $createTobtRequest->init = (bool)$request->input('init');
        $createTobtRequest->tobtable_id = (int)$request->input('tobtable_id');
        $createTobtRequest->tobtable_type = $request->input('tobtable_type');

        $this->setRequestAuthor($createTobtRequest);

        $createTobtResponse = $this->_elementService->createTobt($createTobtRequest);

        if ($createTobtResponse->isError()) {
            return $this->getErrorJson($createTobtResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createTobtResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        $getTobtResponse = $this->_elementService->showTobt($createTobtResponse->dto->id);

        $tobtResponse = new Collection([
            'call_sign' => $getDepartureResponse->dto->call_sign,
            'airport' => $getDepartureResponse->dto->airport->iata,
            'tobt' => $getTobtResponse->dto->tobt,
            'tobt_data_origin' => $getTobtResponse->dto->tobtable->name,
            'tobt_reason' => $getTobtResponse->dto->reason
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();
        broadcast(new SendTobtEvent($tobtResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createTobtResponse, $createTobtResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/tsats",
     *     operationId="actionGetTsats",
     *     tags={"Element","TSAT"},
     *     description="Get tsats",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TsatEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetTsats(int $departureId)
    {
        $getTsatsResponse = $this->_elementService->getTsats($departureId);

        if ($getTsatsResponse->isError()) {
            return $this->getErrorJson($getTsatsResponse);
        }

        return $this->getDataJsonResponse($getTsatsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/tsat",
     *     operationId="actionCreateTsat",
     *     tags={"Element","TSAT"},
     *     description="Create tsat",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/TsatCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TsatEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateTsat(Request $request)
    {
        $createTsatRequest = new CreateElementRequest();

        $createTsatRequest->departure_id = (int)$request->input('departure_id');
        $createTsatRequest->tsat = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('tsat'))) ? new DateTime($request->input('tsat')) : null;
        $createTsatRequest->reason = (string)$request->input('reason');
        $createTsatRequest->init = (bool)$request->input('init');
        $createTsatRequest->tsatable_id = (int)$request->input('tsatable_id');
        $createTsatRequest->tsatable_type = $request->input('tsatable_type');

        $this->setRequestAuthor($createTsatRequest);

        $createTsatResponse = $this->_elementService->createTsat($createTsatRequest);

        if ($createTsatResponse->isError()) {
            return $this->getErrorJson($createTsatResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createTsatResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createTsatResponse, $createTsatResponse->dto);
    }


    /**
     * @OA\Get(
     *     path="/element/{departureId}/ttots",
     *     operationId="actionGetTtots",
     *     tags={"Element","TTOT"},
     *     description="Get ttots",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="departureId",
     *          in="path",
     *          description="Departure id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param int $departureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetTtots(int $departureId)
    {
        $getTtotsResponse = $this->_elementService->getTtots($departureId);

        if ($getTtotsResponse->isError()) {
            return $this->getErrorJson($getTtotsResponse);
        }

        return $this->getDataJsonResponse($getTtotsResponse->dtoCollection());
    }

    /**
     * @OA\Post(
     *     path="/element/ttot",
     *     operationId="actionCreateTtot",
     *     tags={"Element","TTOT"},
     *     description="Create ttot",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(ref="#/components/parameters/timezone"),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="departure_id",
     *                              type="integer",
     *                              format="int64",
     *                              description="Departure id property"
     *                          )
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/TtotCreateRequest")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TtotEloquent")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionCreateTtot(Request $request)
    {
        $createTtotRequest = new CreateElementRequest();

        $createTtotRequest->departure_id = (int)$request->input('departure_id');
        $createTtotRequest->ttot = (DateTime::createFromFormat('Y-m-d H:i:s', $request->input('ttot'))) ? new DateTime($request->input('ttot')) : null;
        $createTtotRequest->reason = (string)$request->input('reason');
        $createTtotRequest->init = (bool)$request->input('init');
        $createTtotRequest->ttotable_id = (int)$request->input('ttotable_id');
        $createTtotRequest->ttotable_type = $request->input('ttotable_type');

        $this->setRequestAuthor($createTtotRequest);

        $createTtotResponse = $this->_elementService->createTtot($createTtotRequest);

        if ($createTtotResponse->isError()) {
            return $this->getErrorJson($createTtotResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createTtotResponse->dto->departure_id);

        $departureResponse = new Collection([
            'timezone' => config('global.timezone'),
            'data' => $getDepartureResponse->dto->toArray()
        ]);

        broadcast(new SendDepartureEvent($departureResponse->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createTtotResponse, $createTtotResponse->dto);
    }
}
