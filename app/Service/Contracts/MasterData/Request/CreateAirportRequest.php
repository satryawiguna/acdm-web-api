<?php
namespace App\Service\Contracts\MasterData\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="CreateAirportRequest",
 *     title="Create Airport Request",
 *     description="Create airport request schema",
 *     required={"name", "slug"}
 * )
 */
class CreateAirportRequest extends AuditableRequest
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
     *     property="location",
     *     type="string",
     *     description="Location property"
     * )
     */
    public ?string $location = null;

    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Country property"
     * )
     */
    public ?string $country = null;

    /**
     * @OA\Property(
     *     property="icao",
     *     type="string",
     *     description="Icao property"
     * )
     */
    public ?string $icao;

    /**
     * @OA\Property(
     *     property="iata",
     *     type="string",
     *     description="Iata property"
     * )
     */
    public ?string $iata;

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
    public function getIcao(): ?string
    {
        return $this->icao;
    }

    /**
     * @param string|null $icao
     */
    public function setIcao(?string $icao): void
    {
        $this->icao = $icao;
    }

    /**
     * @return string|null
     */
    public function getIata(): ?string
    {
        return $this->iata;
    }

    /**
     * @param string|null $iata
     */
    public function setIata(?string $iata): void
    {
        $this->iata = $iata;
    }
}
