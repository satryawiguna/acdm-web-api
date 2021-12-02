<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\System;


use App\Core\Domain\Contracts\IBaseEntity;

interface IPermissionEloquent extends IBaseEntity
{
    const TABLE_NAME = 'permissions';
    const MORPH_NAME = 'permissions';

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getServer(): string;

    public function SetServer(string $server);

    public function getPath(): string;

    public function SetPath(string $path);

    public function getDescription(): ?string;

    public function setDescription(?string $description);
}
