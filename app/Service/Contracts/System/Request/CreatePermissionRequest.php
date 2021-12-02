<?php
namespace App\Service\Contracts\System\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="CreatePermissionRequest",
 *     title="Create Permission Request",
 *     description="Create permission request schema",
 *     required={"name", "slug"}
 * )
 */
class CreatePermissionRequest extends AuditableRequest
{
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
     *     property="server",
     *     type="string",
     *     description="Server property"
     * )
     */
    public string $server;

    /**
     * @OA\Property(
     *     property="path",
     *     type="string",
     *     description="Path property"
     * )
     */
    public string $path;

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description property"
     * )
     */
    public ?string $description;

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
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

    /**
     * @param string $server
     */
    public function setServer(string $server): void
    {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
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
