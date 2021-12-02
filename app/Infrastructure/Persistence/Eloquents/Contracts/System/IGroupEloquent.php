<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\System;


use App\Core\Domain\Contracts\IBaseEntity;

interface IGroupEloquent extends IBaseEntity
{
    const TABLE_NAME = 'groups';
    const MORPH_NAME = 'groups';

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getDescription(): ?string;

    public function setDescription(?string $description);
}
