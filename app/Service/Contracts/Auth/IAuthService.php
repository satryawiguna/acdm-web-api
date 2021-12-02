<?php
namespace App\Service\Contracts\Auth;


use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Service\Contracts\Auth\Request\LoginRequest;
use App\Service\Contracts\Auth\Request\LogoutRequest;
use Illuminate\Support\Collection;

interface IAuthService
{
    public function login(LoginRequest $request): GenericObjectResponse;

    public function loginToApiDocument(LoginRequest $request): GenericObjectResponse;

    public function logout(LogoutRequest $request): BasicResponse;

    public function refreshToken(string $token): GenericObjectResponse;

    public function isPasswordUnique(Collection $users, string $password): bool;
}
