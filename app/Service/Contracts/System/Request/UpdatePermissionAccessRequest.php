<?php
namespace App\Service\Contracts\System\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdatePermissionAccessRequest",
 *     title="Update Permission Access Request",
 *     description="Update permission access request schema",
 *     required={"accesses"}
 * )
 */
class UpdatePermissionAccessRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="accesses",
     *     description="Access ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1,2,3}
     * )
     */
    public array $accesses;

    /**
     * @return array
     */
    public function getAccesses(): array
    {
        return $this->accesses;
    }

    /**
     * @param array $accesses
     */
    public function setAccesses(array $accesses): void
    {
        $this->accesses = $accesses;
    }

}
