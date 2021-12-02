<?php
namespace App\Presentation\Http\Controllers\Auth;


use App\Domain\Membership\UserEloquent;
use App\Presentation\Http\Controllers\WebBaseController;
use App\Presentation\Http\Providers\RouteServiceProvider;
use App\Service\Contracts\Membership\IMembershipService;
use App\Service\Contracts\Membership\Request\RegisterUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RegisterController extends WebBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    private IMembershipService $_membershipService;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @param IMembershipService $membershipService
     */
    public function __construct(IMembershipService $membershipService)
    {
        $this->middleware('guest');
        $this->_membershipService = $membershipService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return UserEloquent
     */
    protected function create(array $data)
    {
        return UserEloquent::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function actionRegister(Request $request, string $group)
    {
        $registerUserRequest = new RegisterUserRequest();

        $registerUserRequest->group = $group;

        $registerUserRequest->email = (string)$request->input('email');
        $registerUserRequest->password = (string)$request->input('password');
        $registerUserRequest->password_confirm = (string)$request->input('password_confirm');
        $registerUserRequest->status = 'PENDING';

        $registerUserRequest->full_name = (string)$request->input('full_name');
        $registerUserRequest->nick_name = (string)$request->input('nick_name');

        $this->setRequestAuthor($registerUserRequest);

        switch ($group) {
            case 'developer':
                $registerUserRequest->groups = [2];
                $registerUserRequest->roles = (array)$request->input('roles');
                break;

            case 'system':
            default:
                $registerUserRequest->groups = [1];
                $registerUserRequest->roles = (array)$request->input('roles');
                break;
        }

        $registerUserResponse = $this->_membershipService->registerUser($registerUserRequest);

        if ($registerUserResponse->isError()) {
            return Redirect::back()->withErrors($registerUserResponse->getMessageResponseErrorTextArray());
        } else {
            event(new Registered($registerUserResponse->dto));

            return Redirect::to('/login')->with('success', $registerUserResponse->getMessageResponseInfoTextArray()[0]);
        }
    }
}
