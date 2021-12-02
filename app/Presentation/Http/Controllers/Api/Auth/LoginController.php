<?php
namespace App\Presentation\Http\Controllers\Api\Auth;


use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\BooleanResponse;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Auth\IAuthService;
use App\Service\Contracts\Auth\Request\LoginRequest;
use App\Service\Contracts\Membership\IMembershipService;
use DateTime;
use Illuminate\Http\Request;

class LoginController extends ApiBaseController
{
    private IAuthService $_authService;
    private IMembershipService $_membershipService;

    public function __construct(IAuthService $authService, IMembershipService $membershipService)
    {
        $this->_authService = $authService;
        $this->_membershipService = $membershipService;
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="actionLogin",
     *     tags={"Authentication"},
     *     description="Login",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/LoginRequest"),
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Loged in"
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
     * @throws \Exception
     */
    public function actionLogin(Request $request)
    {
        $loginRequest = new LoginRequest();

        if (filter_var((string)$request->input('identity'), FILTER_VALIDATE_EMAIL)) {
            $loginRequest->email = (string)$request->input('identity');
        } else {
            $loginRequest->username = (string)$request->input('identity');
        }

        $loginRequest->password = (string)$request->input('password');
        $loginRequest->last_login_at = new DateTime('now');
        $loginRequest->last_login_ip = (string)$request->getClientIp();

        $response = $this->_authService->login($loginRequest);

        if ($response->isError()) {
            return $this->getErrorJson($response);
        }

        return $this->getBasicSuccessWithDataJson($response, $response->dto);
    }

    /**
     * @OA\Post(
     *     path="/refresh-token",
     *     operationId="actionRefreshToken",
     *     tags={"Authentication"},
     *     description="Refresh token",
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
     *                      property="token",
     *                      description="Token property",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Token refreshed"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionRefreshToken(Request $request)
    {
        $token = $request->input('token');

        $response = $this->_authService->refreshToken($token);

        if ($response->isError()) {
            return $this->getErrorJson($response);
        }

        return $this->getBasicSuccessWithDataJson($response, $response->dto);
    }

    public function actionUnauthorized() {
        $response = new BasicResponse();

        $response->addInfoMessageResponse('Unauthorized');
        $response->setStatus(401);

        return $this->getErrorJson($response);
    }

    /**
     * @OA\Post(
     *     path="/check-password",
     *     operationId="actionCheckPassword",
     *     tags={"Authentication"},
     *     description="Check password",
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
     *                      property="password",
     *                      description="Password property",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Check password"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionCheckPassword(Request $request)
    {
        $password = $request->input('password');

        $userResponse = $this->_membershipService->getUsers();

        $users = $userResponse->dtoCollection();

        $response = new BooleanResponse();
        $response->result = $this->_authService->isPasswordUnique($users, $password);

        if ($response->result) {
            $response->addInfoMessageResponse('Password is unique');
        } else {
            $response->addInfoMessageResponse('Password is not unique');
        }

        return $this->getBasicSuccessJson($response);
    }
}
