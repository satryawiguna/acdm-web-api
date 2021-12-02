<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Membership;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IUserEloquent extends IBaseEntity
{
    const TABLE_NAME = 'users';
    const MORPH_NAME = 'users';

    public function getUsername(): string;

    public function setUsername(string $username);

    public function getEmail(): string;

    public function setEmail(string $email);

    public function getPassword(): string;

    public function setPassword(string $password);

    public function getStatus(): string;

    public function setStatus(string $status);

    public function getLastLoginAt(): DateTime;

    public function setLastLoginAt(DateTime $last_login_at);

    public function getLastLoginIp(): string;

    public function setLastLoginIp(string $last_login_ip);
}
