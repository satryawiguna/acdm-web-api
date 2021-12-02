<?php
namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserPermissionRequest",
 *     title="Update User Permission Request",
 *     description="Update user permission request schema",
 *     required={"permissions"}
 * )
 */
class UpdateUserPermissionRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="permissions",
     *     description="Permissions property",
     *     type="array",
     *     @OA\Items(
     *          @OA\Property(
     *              property="permission_id",
     *              type="integer",
     *              format="int64"
     *          ),
     *          @OA\Property(
     *              property="pivot",
     *              @OA\Property(
     *                  property="value",
     *                  example="INHERIT | ALLOW | DENY"
     *              ),
     *          )
     *     )
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
