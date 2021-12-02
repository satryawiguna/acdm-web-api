<?php
namespace App\Service\Contracts\MasterData\Request;


use App\Core\Service\Request\IdentityAuditableRequest;


/**
 * @OA\Schema(
 *     schema="UpdateAirportRequest",
 *     title="Update Airport Request",
 *     description="Update airport request schema",
 *     required={"name", "slug"}
 * )
 */
class UpdateAirportRequest extends IdentityAuditableRequest
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
    public ?string $location;

    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Country property"
     * )
     */
    public ?string $country;

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
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
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
