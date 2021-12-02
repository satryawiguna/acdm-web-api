<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\System;


use App\Core\Domain\Contracts\IBaseEntity;

interface IAccessEloquent extends IBaseEntity
{
    const TABLE_NAME = 'accesses';
    const MORPH_NAME = 'accesses';

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getDescription(): ?string;

    public function setDescription(?string $description);
}
