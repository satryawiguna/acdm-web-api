<?php
namespace App\Service\Contracts\MasterData\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="CreateAirlineRequest",
 *     title="Create Airline Request",
 *     description="Create airline request schema",
 *     required={"name", "slug", "flight_number"}
 * )
 */
class CreateAirlineRequest extends AuditableRequest
{
    /**
     * @OA\Property(
     *     property="flight_number",
     *     type="string",
     *     description="Flight number property"
     * )
     */
    public string $flight_number;

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
     * @OA\Property(
     *     property="call_sign",
     *     type="string",
     *     description="Call sign property"
     * )
     */
    public ?string $call_sign;

    /**
     * @return string
     */
    public function getFlightNumber(): string
    {
        return $this->flight_number;
    }

    /**
     * @param string $flight_number
     */
    public function setFlightNumber(string $flight_number): void
    {
        $this->flight_number = $flight_number;
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

    /**
     * @return string|null
     */
    public function getCallSign(): ?string
    {
        return $this->call_sign;
    }

    /**
     * @param string|null $call_sign
     */
    public function setCallSign(?string $call_sign): void
    {
        $this->call_sign = $call_sign;
    }
}
