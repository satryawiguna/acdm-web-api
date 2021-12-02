<?php


namespace App\Service\Contracts\MasterData\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="CreateOrganizationRequest",
 *     title="Create Organization Request",
 *     description="Create organization request schema",
 *     required={"name", "slug", "country_id"}
 * )
 */
class CreateOrganizationRequest extends AuditableRequest
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
     *     property="country_id",
     *     type="integer",
     *     format="int64",
     *     description="Country id property"
     * )
     */
    public int $country_id;

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description property"
     * )
     */
    public ?string $description;

    /**
     * @OA\Property(
     *     property="vendors",
     *     description="Vendors property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/CreateVendorRequest")
     * )
     */
    public ?array $vendors = null;

    /**
     * @OA\Property(
     *     property="media",
     *     description="Media property",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="media_id",
     *             description="Media id property",
     *             type="string",
     *             example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *         ),
     *         @OA\Property(
     *             property="pivot",
     *             description="Pivot property",
     *             @OA\Property(
     *                 property="attribute",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     */
    public ?array $media = null;

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
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->country_id;
    }

    /**
     * @param int $country_id
     */
    public function setCountryId(int $country_id): void
    {
        $this->country_id = $country_id;
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

    /**
     * @return array|null
     */
    public function getVendors(): ?array
    {
        return $this->vendors;
    }

    /**
     * @param array|null $vendors
     */
    public function setVendors(?array $vendors): void
    {
        $this->vendors = $vendors;
    }

    /**
     * @return array|null
     */
    public function getMedia(): ?array
    {
        return $this->media;
    }

    /**
     * @param array|null $media
     */
    public function setMedia(?array $media): void
    {
        $this->media = $media;
    }
}
