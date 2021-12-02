<?php


namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="CreateProfileRequest",
 *     title="Create Profile Request",
 *     description="Create profile request schema",
 *     required={"email", "password", "full_name", "nick_name"}
 * )
 */
class CreateProfileRequest extends AuditableRequest
{
    /**
     * @OA\Property(
     *     property="full_name",
     *     description="Full name property",
     *     type="string"
     * )
     */
    public string $full_name;

    /**
     * @OA\Property(
     *     property="nick_name",
     *     description="Nick name property",
     *     type="string"
     * )
     */
    public string $nick_name;

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
     *     property="state",
     *     type="string",
     *     description="State property"
     * )
     */
    public ?string $state;

    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="City property"
     * )
     */
    public ?string $city;

    /**
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Address property"
     * )
     */
    public ?string $address;

    /**
     * @OA\Property(
     *     property="postcode",
     *     type="string",
     *     description="Postcode property"
     * )
     */
    public ?string $postcode;

    /**
     * @OA\Property(
     *     property="gender",
     *     type="string",
     *     description="Gender property"
     * )
     */
    public ?string $gender;

    /**
     * @OA\Property(
     *     property="birth_date",
     *     type="string",
     *     format="date-time",
     *     description="Birth date property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     */
    public ?DateTime $birth_date;

    /**
     * @OA\Property(
     *     property="mobile",
     *     type="string",
     *     description="Mobile property"
     * )
     */
    public ?string $mobile;

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email property"
     * )
     */
    public ?string $email;

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName(string $full_name): void
    {
        $this->full_name = $full_name;
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nick_name;
    }

    /**
     * @param string $nick_name
     */
    public function setNickName(string $nick_name): void
    {
        $this->nick_name = $nick_name;
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
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @param string|null $postcode
     */
    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birth_date;
    }

    /**
     * @param DateTime|null $birth_date
     */
    public function setBirthDate(?DateTime $birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     */
    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
