<?php
namespace App\Service\Contracts\Auth\Request;


use DateTime;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     title="Login Request",
 *     description="Login request schema",
 *     required={"identity", "password"}
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *     property="identity",
     *     type="string",
     *     description="Identity property"
     * )
     */

    public string $username;

    public string $email;

    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="Password property"
     * )
     */
    public string $password;

    public DateTime $last_login_at;

    public string $last_login_ip;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return DateTime
     */
    public function getLastLoginAt(): DateTime
    {
        return $this->last_login_at;
    }

    /**
     * @param DateTime $last_login_at
     */
    public function setLastLoginAt(DateTime $last_login_at): void
    {
        $this->last_login_at = $last_login_at;
    }

    /**
     * @return string
     */
    public function getLastLoginIp(): string
    {
        return $this->last_login_ip;
    }

    /**
     * @param string $last_login_ip
     */
    public function setLastLoginIp(string $last_login_ip): void
    {
        $this->last_login_ip = $last_login_ip;
    }
}
