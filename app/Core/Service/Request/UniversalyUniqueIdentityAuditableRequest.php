<?php
namespace App\Core\Service\Request;


/**
 * @OA\Schema(
 *     schema="UniversalyUniqueIdentityAuditableRequest",
 *     title="Universaly Unique Identity Auditable Request",
 *     description="Universaly unique identity auditable request schema",
 *     required={"uuid"}
 * )
 */
class UniversalyUniqueIdentityAuditableRequest extends AuditableRequest
{
    /**
     * @OA\Property(
     *     property="uuid",
     *     type="string",
     *     description="Universaly unique identity property"
     * )
     */
    public string $uuId;

    /**
     * @return string
     */
    public function getUuId(): string
    {
        return $this->uuId;
    }

    /**
     * @param string $uuId
     */
    public function setUuId(string $uuId): void
    {
        $this->uuId = $uuId;
    }
}
