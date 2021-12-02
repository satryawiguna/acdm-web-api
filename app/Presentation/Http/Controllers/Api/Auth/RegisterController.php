<?php
namespace App\Presentation\Http\Controllers\Api\Auth;


use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Membership\IMembershipService;
use App\Service\Contracts\Membership\Request\RegisterUserRequest;
use Illuminate\Http\Request;

class RegisterController extends ApiBaseController
{
    private IMembershipService $_membershipService;

    public function __construct(IMembershipService $membershipService)
    {
        $this->_membershipService = $membershipService;
    }

    /**
     * @OA\Post(
     *     path="/register/{group}",
     *     operationId="actionRegister",
     *     tags={"Authentication"},
     *     description="Register",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="group",
     *          in="path",
     *          description="Group parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"SYSTEM","DEVELOPER"}
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/RegisterUserRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="User registered"
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
     * @param string $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionRegister(Request $request, string $group)
    {
        $registerUserRequest = new RegisterUserRequest();

        $registerUserRequest->group = $group;

        $registerUserRequest->email = (string)$request->input('email');
        $registerUserRequest->username = (string)$request->input('username');
        $registerUserRequest->password = (string)$request->input('password');
        $registerUserRequest->password_confirm = (string)$request->input('password_confirm');
        $registerUserRequest->status = 'PENDING';

        $registerUserRequest->full_name = (string)$request->input('full_name');
        $registerUserRequest->nick_name = (string)$request->input('nick_name');

        $this->setRequestAuthor($registerUserRequest);

        switch ($group) {
            case 'developer':
                $registerUserRequest->groups = [2];
                break;

            case 'system':
            default:
                $registerUserRequest->groups = [1];
                break;
        }

        $registerUserRequest->roles = (array)$request->input('roles');
        $registerUserRequest->vendors = (array)$request->input('vendors');

        $registerUserResponse = $this->_membershipService->registerUser($registerUserRequest);

        if ($registerUserResponse->isError()) {
            return $this->getErrorJson($registerUserResponse);
        }

        return $this->getBasicSuccessJson($registerUserResponse);
    }
}
