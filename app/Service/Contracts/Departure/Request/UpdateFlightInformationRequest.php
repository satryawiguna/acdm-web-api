<?php


namespace App\Service\Contracts\Departure\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateFlightInformationRequest",
 *     title="Update Flight Information Request",
 *     description="Update flight information request schema",
 *     required={"id", "departure_id", "type", "role_id"}
 * )
 */
class UpdateFlightInformationRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="Id property"
     * )
     */

    /**
     * @OA\Property(
     *     property="departure_id",
     *     type="integer",
     *     format="int64",
     *     description="Departure id property"
     * )
     */
    public int $departure_id;

    /**
     * @OA\Property(
     *     property="type",
     *     type="string",
     *     description="Type property",
     *     example="PRIORITY"
     * )
     */
    public string $type;

    /**
     * @OA\Property(
     *     property="reason",
     *     type="string",
     *     description="Reason property"
     * )
     */
    public ?string $reason;

    /**
     * @OA\Property(
     *     property="role_id",
     *     type="integer",
     *     format="int64",
     *     description="Role id property"
     * )
     */
    public int $role_id;

    /**
     * @return int
     */
    public function getDepartureId(): int
    {
        return $this->departure_id;
    }

    /**
     * @param int $departure_id
     */
    public function setDepartureId(int $departure_id): void
    {
        $this->departure_id = $departure_id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    /**
     * @param int $role_id
     */
    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }
}
