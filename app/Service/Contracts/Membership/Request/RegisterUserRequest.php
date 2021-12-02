<?php
namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="RegisterUserRequest",
 *     title="Register User Request",
 *     description="Register user request schema",
 *     required={"email", "password", "full_name", "nick_name"}
 * )
 */
class RegisterUserRequest extends AuditableRequest
{
    public string $group;

    //User
    /**
     * @OA\Property(
     *     property="email",
     *     description="Email property",
     *     type="string"
     * )
     */
    public string $email;

    /**
     * @OA\Property(
     *     property="username",
     *     description="Username property",
     *     type="string"
     * )
     */
    public string $username;

    /**
     * @OA\Property(
     *     property="password",
     *     description="Password property",
     *     type="string"
     * )
     */
    public string $password;

    /**
     * @OA\Property(
     *     property="password_confirm",
     *     description="Password confirm property",
     *     type="string"
     * )
     */
    public string $password_confirm;

    /**
     * @OA\Property(
     *     property="status",
     *     description="Status property",
     *     type="string"
     * )
     */
    public string $status;

    //User Group
    public array $groups;

    //User Role
    /**
     * @OA\Property(
     *     property="roles",
     *     description="Role ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1}
     * )
     */
    public array $roles;

    //User Vendor
    /**
     * @OA\Property(
     *     property="vendors",
     *     description="Vendor ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1}
     * )
     */
    public array $vendors;

    //User Profile
    public int $profileable_id;

    public string $profileable_type;

    /**
     * @OA\Property(
     *     property="full_name",
     *     description="Full name property",
     *     type="string"
     * )
     */
    public string $full_name;

    /**
     * @OA\Property(
     *     property="nick_name",
     *     description="Nick name property",
     *     type="string"
     * )
     */
    public string $nick_name;

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
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
     * @return string
     */
    public function getPasswordConfirm(): string
    {
        return $this->password_confirm;
    }

    /**
     * @param string $password_confirm
     */
    public function setPasswordConfirm(string $password_confirm): void
    {
        $this->password_confirm = $password_confirm;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     */
    public function setGroupIds(array $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoleIds(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getVendors(): array
    {
        return $this->vendors;
    }

    /**
     * @param array $vendors
     */
    public function setVendors(array $vendors): void
    {
        $this->vendors = $vendors;
    }

    /**
     * @return int
     */
    public function getProfileableId(): int
    {
        return $this->profileable_id;
    }

    /**
     * @param int $profileable_id
     */
    public function setProfileableId(int $profileable_id): void
    {
        $this->profileable_id = $profileable_id;
    }

    /**
     * @return string
     */
    public function getProfileableType(): string
    {
        return $this->profileable_type;
    }

    /**
     * @param string $profileable_type
     */
    public function setProfileableType(string $profileable_type): void
    {
        $this->profileable_type = $profileable_type;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName(string $full_name): void
    {
        $this->full_name = $full_name;
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nick_name;
    }

    /**
     * @param string $nick_name
     */
    public function setNickName(string $nick_name): void
    {
        $this->nick_name = $nick_name;
    }
}
