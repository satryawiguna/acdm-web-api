<?php


namespace App\Infrastructure\Persistence\Eloquents\Contracts\MasterData;


use App\Core\Domain\Contracts\IBaseEntity;

interface ICountryEloquent extends IBaseEntity
{
    const TABLE_NAME = 'countries';
    const MORPH_NAME = 'countries';

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getCallingCode(): string;

    public function setCallingCode(string $calling_code);

    public function getIsoCodeTwoDigit(): string;

    public function setIsoCodeTwoDigit(string $iso_code_two_digit);

    public function getIsoCodeThreeDigit(): string;

    public function setIsoCodeThreeDigit(string $iso_code_three_digit);
}
