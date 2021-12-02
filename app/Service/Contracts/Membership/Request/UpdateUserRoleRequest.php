<?php
namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserRoleRequest",
 *     title="Update User Role Request",
 *     description="Update user role request schema",
 *     required={"roles"}
 * )
 */
class UpdateUserRoleRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="roles",
     *     description="Role ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1,2,3}
     * )
     */
    public array $roles;

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
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
