<?php


namespace App\Service\Contracts\MasterData\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCountryRequest",
 *     title="Update Country Request",
 *     description="Update country request schema",
 *     required={"id", "name", "slug"}
 * )
 */
class UpdateCountryRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property"
     * )
     */
    public int $name;

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
     *     property="calling_code",
     *     type="string",
     *     description="Calling code property"
     * )
     */
    public ?string $calling_code;

    /**
     * @OA\Property(
     *     property="iso_code_two_digit",
     *     type="string",
     *     description="Iso code two digit property"
     * )
     */
    public ?string $iso_code_two_digit;

    /**
     * @OA\Property(
     *     property="iso_code_three_digit",
     *     type="string",
     *     description="Iso code three digit property"
     * )
     */
    public ?string $iso_code_three_digit;

    /**
     * @return int
     */
    public function getName(): int
    {
        return $this->name;
    }

    /**
     * @param int $name
     */
    public function setName(int $name): void
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
    public function getCallingCode(): ?string
    {
        return $this->calling_code;
    }

    /**
     * @param string|null $calling_code
     */
    public function setCallingCode(?string $calling_code): void
    {
        $this->calling_code = $calling_code;
    }

    /**
     * @return string|null
     */
    public function getIsoCodeTwoDigit(): ?string
    {
        return $this->iso_code_two_digit;
    }

    /**
     * @param string|null $iso_code_two_digit
     */
    public function setIsoCodeTwoDigit(?string $iso_code_two_digit): void
    {
        $this->iso_code_two_digit = $iso_code_two_digit;
    }

    /**
     * @return string|null
     */
    public function getIsoCodeThreeDigit(): ?string
    {
        return $this->iso_code_three_digit;
    }

    /**
     * @param string|null $iso_code_three_digit
     */
    public function setIsoCodeThreeDigit(?string $iso_code_three_digit): void
    {
        $this->iso_code_three_digit = $iso_code_three_digit;
    }
}
