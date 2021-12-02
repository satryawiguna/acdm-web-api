<?php
namespace App\Service\Auth;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Domain\Contracts\Membership\IUserRepository;
use App\Help\Service\ResponseType;
use App\Service\BaseService;
use App\Service\Contracts\Auth\IAuthService;
use App\Service\Contracts\Auth\Request\LoginRequest;
use App\Service\Contracts\Auth\Request\LogoutRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client as OClient;

class AuthService extends BaseService implements IAuthService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IUserRepository $_userRepository;

    /**
     * AuthService constructor.
     * @param IUnitOfWorkFactory $unitOfWorkFactory
     * @param IUserRepository $userRepository
     */
    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IUserRepository $userRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;
        $this->_userRepository = $userRepository;
    }

    public function login(LoginRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $rules = [
                'password' => 'required|string'
            ];

            $identity = null;

            if (isset($request->email)) {
                $rules['email'] = 'required|string|email';
                $identity = $request->email;
            }

            if (isset($request->username)) {
                $rules['username'] = 'required|string';
                $identity = $request->username;
            }

            $user = $this->_userRepository->findUserLogin($identity)
                ->first();

            if (!$user) {
                $response->addErrorMessageResponse('Credentials doesn\'t match');
                $response->setStatus(ResponseType::BAD_REQUEST()->getValue());

                return $response;
            }

            if (!Hash::check($request->password, $user->password)) {
                $response->addErrorMessageResponse('Password doesn\'t match');
                $response->setStatus(ResponseType::BAD_REQUEST()->getValue());

                return $response;
            }

            if ($user->status != 'ACTIVE') {
                $response->addErrorMessageResponse('Account doesn\'t active');
                $response->setStatus(ResponseType::BAD_REQUEST()->getValue());

                return $response;
            }

            //Overwrite permission and access
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $permission) {
                    $userPermission = $this->_userRepository->findUserPermission($user->id, $permission->id);

                    if ($userPermission->permissions->count() > 0) {
                        $permission->value = $userPermission->permissions->first()->value;
                    }

                    foreach ($permission->accesses as $access) {
                        $userAccess = $this->_userRepository->findUserAccess($user->id, $permission->id, $access->id);

                        if ($userAccess->accesses->count() > 0) {
                            $access->value = $userAccess->accesses->first()->value;
                        }
                    }
                }
            }

            $brokenRules = $user->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                        $response->setStatus(ResponseType::BAD_REQUEST()->getValue());
                    }
                }

                return $response;
            }

            $user->setAttribute('last_login_ip', $request->last_login_ip);
            $user->setAttribute('last_login_at', $request->last_login_at->format(Config::get('datetime.format.database_datetime')));

            $oClient = OClient::where('password_client', 1)->first();

            $http = new Client(['verify' => false]);
            $result = $http->request('POST', env('APP_URL') . 'oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'username' => $user->email,
                    'password' => $request->password,
                    'scope' => '*'
                ]
            ]);

            $token = json_decode((string) $result->getBody(), true);

            $unitOfWork->markDirty($this->_userRepository, $user);
            $unitOfWork->commit();

            $response->dto = (object)[
                'user' => $user,
                'token' => $token
            ];

            $response->addInfoMessageResponse('Login success');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function loginToApiDocument(LoginRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $rules = [
                'email' => 'required|string|email',
                'password' => 'required|string'
            ];

            $user = $this->_userRepository->findUserLoginToApiDocument($request->email)
                ->first();

            if (!$user) {
                $response->addErrorMessageResponse('Credentials doesn\'t match');
                $response->setStatus(ResponseType::BAD_REQUEST()->getValue());

                return $response;
            }

            if (!Hash::check($request->password, $user->password)) {
                $response->addErrorMessageResponse('Password doesn\'t match');
                $response->setStatus(ResponseType::BAD_REQUEST()->getValue());

                return $response;
            }

            if ($user->status != 'ACTIVE') {
                $response->addErrorMessageResponse('Account is not active');
                $response->setStatus(ResponseType::BAD_REQUEST()->getValue());

                return $response;
            }

            $brokenRules = $user->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                        $response->setStatus(ResponseType::BAD_REQUEST()->getValue());
                    }
                }

                return $response;
            }

            $user->setAttribute('last_login_ip', $request->last_login_ip);
            $user->setAttribute('last_login_at', $request->last_login_at->format(Config::get('datetime.format.database_datetime')));

            $unitOfWork->markDirty($this->_userRepository, $user);
            $unitOfWork->commit();

            $response->dto = $user;
            $response->addInfoMessageResponse('Login success');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function logout(LogoutRequest $request): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $user = $this->_userRepository->find($request->id);

            $oAuthAccessTokens = $user->oAuthAccessTokens();
            $oAuthAccessTokens->delete();

            $response->addInfoMessageResponse('Successfully logged out');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function refreshToken(string $token): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $oClient = OClient::where('password_client', 1)->first();

            $http = new Client(['verify' => false]);
            $result = $http->request('POST', env('APP_URL') . 'oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token,
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'scope' => '*'
                ]
            ]);

            $token = json_decode((string) $result->getBody(), true);

            $response->dto = new Collection([
                'token' => $token
            ]);

            $response->addInfoMessageResponse('Token refresh');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function isPasswordUnique(Collection $users, string $password): bool
    {
        foreach ($users as $user) {
            if (Hash::check($password, $user->password)) {
                return false;
            }
        }

        return true;
    }
}
