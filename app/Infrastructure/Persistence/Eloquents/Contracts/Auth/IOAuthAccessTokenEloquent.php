<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Auth;


use App\Core\Domain\Contracts\IBaseEntity;

interface IOAuthAccessTokenEloquent extends IBaseEntity
{
    const TABLE_NAME = 'oauth_access_tokens';
    const MORPH_NAME = 'oauth_access_tokens';

    public function getUserId(): int;

    public function setUserId(int $user_id);

    public function getClientId(): string;

    public function setClientId(string $client_id);

    public function getName(): string;

    public function setName(string $name);

    public function getScope(): string;

    public function setScope(string $scope);

    public function getRevoked(): int;

    public function setRevoked(int $revoked);
}
