<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\System;


use App\Core\Domain\Contracts\IBaseEntity;

interface IRoleEloquent extends IBaseEntity
{
    const TABLE_NAME = 'roles';
    const MORPH_NAME = 'roles';

    public function getGroupId(): int;

    public function setGroupId(int $group_id);

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getDescription(): ?string;

    public function setDescription(?string $description);
}
