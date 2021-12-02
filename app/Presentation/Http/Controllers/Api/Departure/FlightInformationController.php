<?php

namespace App\Presentation\Http\Controllers\Api\Departure;

use App\Events\Broadcast\SendDepartureEvent;
use App\Http\Controllers\Controller;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Departure\IDepartureService;
use App\Service\Contracts\Departure\IFlightInformationService;
use App\Service\Contracts\Departure\Request\CreateFlightInformationRequest;
use Illuminate\Http\Request;

class FlightInformationController extends ApiBaseController
{
    private IFlightInformationService $_flightInformationService;
    private IDepartureService $_departureService;

    public function __construct(IFlightInformationService $flightInformationService,
                                IDepartureService $departureService)
    {
        $this->_flightInformationService = $flightInformationService;
        $this->_departureService = $departureService;
    }

    /**
     * @OA\Post(
     *     path="/flight-information",
     *     operationId="actionCreateFlightInformation",
     *     tags={"Flight Information"},
     *     description="Create flight information",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateFlightInformationRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/FlightInformationEloquent")
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
    public function actionCreateFlightInformation(Request $request)
    {
        $createFlightInformationRequest = new CreateFlightInformationRequest();

        $createFlightInformationRequest->departure_id = (int)$request->input('departure_id');
        $createFlightInformationRequest->type = (string)$request->input('type') ?? null;
        $createFlightInformationRequest->reason = (string)$request->input('reason') ?? null;
        $createFlightInformationRequest->role_id = (int)$request->input('role_id');

        $this->setRequestAuthor($createFlightInformationRequest);

        $createFlightInformationResponse = $this->_flightInformationService->createFlightInformation($createFlightInformationRequest);

        if ($createFlightInformationResponse->isError()) {
            return $this->getErrorJson($createFlightInformationResponse);
        }

        $getDepartureResponse = $this->_departureService->showDeparture($createFlightInformationResponse->dto->departure_id);

        broadcast(new SendDepartureEvent($getDepartureResponse->dto->toArray()))->toOthers();

        return $this->getBasicSuccessWithDataJson($createFlightInformationResponse, $createFlightInformationResponse->dto);
    }

    /**
     * @OA\Get(
     *     path="/flight-information/{departureId}/latest",
     *     operationId="actionGetLatestFlightInformation",
     *     tags={"Flight Information"},
     *     description="Get flight informations",
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
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/FlightInformationEloquent")
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
    public function actionGetLatestFlightInformation(int $departureId)
    {
        $getLatestFlightInformationResponse = $this->_flightInformationService->getLatestFlightInformation($departureId);

        if ($getLatestFlightInformationResponse->isError()) {
            return $this->getErrorJson($getLatestFlightInformationResponse);
        }

        return $this->getDataJsonResponse($getLatestFlightInformationResponse->dto);
    }
}
