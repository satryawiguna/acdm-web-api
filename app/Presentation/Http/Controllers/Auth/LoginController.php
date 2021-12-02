<?php
namespace App\Presentation\Http\Controllers\Auth;

use App\Presentation\Http\Controllers\WebBaseController;
use App\Presentation\Http\Providers\RouteServiceProvider;
use App\Service\Contracts\Auth\IAuthService;
use App\Service\Contracts\Auth\Request\LoginRequest;
use DateTime;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends WebBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private IAuthService $_authService;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @param IAuthService $authService
     */
    public function __construct(IAuthService $authService)
    {
        $this->_authService = $authService;

        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $loginRequest = new LoginRequest();

        $loginRequest->email = (string)$request->input('email');
        $loginRequest->password = (string)$request->input('password');
        $loginRequest->last_login_at = new DateTime('now');
        $loginRequest->last_login_ip = (string)$request->getClientIp();

        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $loginResponse = $this->_authService->loginToApiDocument($loginRequest);

        if ($loginResponse->isError()) {
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
