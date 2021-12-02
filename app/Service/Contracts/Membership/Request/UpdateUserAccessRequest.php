<?php
namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserAccessRequest",
 *     title="Update User Access Request",
 *     description="Update user access request schema",
 *     required={"accesses"}
 * )
 */
class UpdateUserAccessRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="accesses",
     *     description="Accesses property",
     *     type="array",
     *     @OA\Items(
     *          @OA\Property(
     *              property="access_id",
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
