<?php


namespace App\Service\Contracts\MasterData\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateVendorRequest",
 *     title="Update Vendor Request",
 *     description="Update vendor request schema",
 *     required={"role_id", "name", "slug"}
 * )
 */
class UpdateVendorRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="role_id",
     *     type="integer",
     *     format="int32",
     *     description="Role id property"
     * )
     */
    public int $role_id;

    /**
     * @OA\Property(
     *     property="organization_id",
     *     type="integer",
     *     format="int64",
     *     description="Organization id property"
     * )
     */
    public int $organization_id;

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property"
     * )
     */
    public string $name;

    /**
     * @OA\Property(
     *     property="slug",
     *     type="string",
     *     description="Slug property"
     * )
     */
    public string $slug;

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Slug property"
     * )
     */
    public ?string $description;

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

    /**
     * @return int
     */
    public function getOrganizationId(): int
    {
        return $this->organization_id;
    }

    /**
     * @param int $organization_id
     */
    public function setOrganizationId(int $organization_id): void
    {
        $this->organization_id = $organization_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
