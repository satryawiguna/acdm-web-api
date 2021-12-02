<?php
namespace App\Service\Contracts\Auth\Request;


/**
 * @OA\Schema(
 *     schema="LogoutRequest",
 *     title="Logout Request",
 *     description="Logout request schema",
 *     required={"id"}
 * )
 */
class LogoutRequest
{
    /**
     * @OA\Property(
     *     property="id",
     *     description="Id property",
     *     type="integer",
     *     format="int64"
     * )
     */
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
