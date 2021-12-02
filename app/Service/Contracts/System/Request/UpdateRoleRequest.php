<?php
namespace App\Service\Contracts\System\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateRoleRequest",
 *     title="Update Role Request",
 *     description="Update role request schema",
 *     required={"id", "group_id", "name", "slug"}
 * )
 */
class UpdateRoleRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="group_id",
     *     type="integer",
     *     format="int64",
     *     description="Group id property"
     * )
     */
    public int $group_id;

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
     *     description="Description property"
     * )
     */
    public ?string $description;

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->group_id;
    }

    /**
     * @param int $group_id
     */
    public function setGroupId(int $group_id): void
    {
        $this->group_id = $group_id;
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
