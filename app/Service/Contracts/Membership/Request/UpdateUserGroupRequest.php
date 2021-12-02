<?php
namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserGroupRequest",
 *     title="Update User Group Request",
 *     description="Update user group request schema",
 *     required={"groups"}
 * )
 */
class UpdateUserGroupRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="groups",
     *     description="Group ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1,2,3}
     * )
     */
    public array $groups;

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
    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

}
