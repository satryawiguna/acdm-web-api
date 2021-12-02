<?php
namespace App\Core\Service\Request;

/**
 * @OA\Schema(
 *     schema="IdentityAuditableRequest",
 *     title="Identity Auditable Request",
 *     description="Identity auditable request schema",
 *     required={"id"}
 * )
 */
class IdentityAuditableRequest extends AuditableRequest
{
    public int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
