<?php
namespace App\Service\Contracts\System\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateRolePermissionRequest",
 *     title="Update Role Permission Request",
 *     description="Update role permission request schema",
 *     required={"accesses"}
 * )
 */
class UpdateRolePermissionRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="permissions",
     *     description="Permission ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1,2,3}
     * )
     */
    public array $permissions;

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }

}
