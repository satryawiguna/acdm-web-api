<?php


namespace App\Infrastructure\Persistence\Eloquents\Contracts\MasterData;


use App\Core\Domain\Contracts\IBaseEntity;

interface IVendorEloquent extends IBaseEntity
{
    const TABLE_NAME = 'vendors';
    const MORPH_NAME = 'vendors';

    public function getRoleId(): int;

    public function setRoleId(int $roleId);

    public function getOrganizationId(): int;

    public function setOrganizationId(int $organizationId);

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);
}
