<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Media;


use App\Core\Domain\Contracts\IBaseEntity;

interface IMediaEloquent extends IBaseEntity
{
    const TABLE_NAME = 'medias';
    const MORPH_NAME = 'medias';

    public function getUserId(): int;

    public function setUserId(int $user_id);

    public function getCollection(): string;

    public function setCollection(string $collection);

    public function getOriginalName(): string;

    public function setOriginalName(string $original_name);

    public function getGenerateName(): string;

    public function setGenerateName(string $generate_name);

    public function getExtension(): string;

    public function setExtension(string $extension);

    public function getMimeType(): string;

    public function setMimeType(string $mime_type);

    public function getPath(): string;

    public function setPath(string $path);

    public function getUrl(): string;

    public function setUrl(string $url);

    public function getWidth(): ?int;

    public function setWidth(?int $width);

    public function getHeight(): ?int;

    public function setHeight(?int $height);

    public function getSize(): int;

    public function setSize(int $size);
}
