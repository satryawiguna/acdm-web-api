<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Membership;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IProfileEloquent extends IBaseEntity
{
    const TABLE_NAME = 'profiles';
    const MORPH_NAME = 'profiles';

    public function getProfileableId(): int;

    public function setProfileableId(int $profileable_id);

    public function getProfileableType(): string;

    public function setProfileableType(string $profileable_type);

    public function getFullName(): string;

    public function setFullName(string $full_name);

    public function getNickName(): ?string;

    public function setNickName(?string $nick_name);

    public function getCountry(): ?string;

    public function setCountry(?string $country);

    public function getState(): ?string;

    public function setState(?string $state);

    public function getCity(): ?string;

    public function setCity(?string $city);

    public function getAddress(): ?string;

    public function setAddress(?string $address);

    public function getPostcode(): ?string;

    public function setPostcode(?string $postcode);

    public function getGender(): ?string;

    public function setGender(?string $gender);

    public function getBirthDate(): ?DateTime;

    public function setBirthDate(?DateTime $birth_date);

    public function getMobile(): ?string;

    public function setMobile(?string $mobile);

    public function getEmail(): string;

    public function setEmail(string $email);
}
