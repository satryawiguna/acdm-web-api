<?php


namespace App\Infrastructure\Persistence\Eloquents\Contracts\MasterData;


use App\Core\Domain\Contracts\IBaseEntity;

interface IOrganizationEloquent extends IBaseEntity
{
    const TABLE_NAME = 'organizations';
    const MORPH_NAME = 'organizations';

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getCountryId(): int;

    public function setCountryId(int $country_id);

    public function getDescription(): string;

    public function setDescription(string $description);
}
