<?php

namespace App\Presentation\Http\Controllers\Api\Auth;

use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Auth\IAuthService;
use App\Service\Contracts\Auth\Request\LogoutRequest;
use Illuminate\Http\Request;

class LogoutController extends ApiBaseController
{
    private IAuthService $_authService;

    /**
     * LoginController constructor.
     * @param IAuthService $authService
     */
    public function __construct(IAuthService $authService)
    {
        $this->_authService = $authService;
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="actionLogout",
     *     tags={"Authentication"},
     *     description="Logout",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/LogoutRequest"),
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Loged out"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionLogout(Request $request) {
        $logoutRequest = new LogoutRequest();

        $logoutRequest->id = (int)$request->input('id');

        $response = $this->_authService->logout($logoutRequest);

        return $this->getBasicSuccessJson($response);
    }
}
