<?php


namespace App\Service\Contracts\Media\Request;


use App\Core\Service\Request\AuditableRequest;

class CreateMediaRequest extends AuditableRequest
{
    public int $user_id;

    public string $collection;

    public string $original_name;

    public string $generate_name;

    public string $extension;

    public string $mime_type;

    public string $path;

    public string $url;

    public ?string $width;

    public ?string $height;

    public string $size;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getCollection(): string
    {
        return $this->collection;
    }

    /**
     * @param string $collection
     */
    public function setCollection(string $collection): void
    {
        $this->collection = $collection;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->original_name;
    }

    /**
     * @param string $original_name
     */
    public function setOriginalName(string $original_name): void
    {
        $this->original_name = $original_name;
    }

    /**
     * @return string
     */
    public function getGenerateName(): string
    {
        return $this->generate_name;
    }

    /**
     * @param string $generate_name
     */
    public function setGenerateName(string $generate_name): void
    {
        $this->generate_name = $generate_name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    /**
     * @param string $mime_type
     */
    public function setMimeType(string $mime_type): void
    {
        $this->mime_type = $mime_type;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * @param string|null $width
     */
    public function setWidth(?string $width): void
    {
        $this->width = $width;
    }

    /**
     * @return string|null
     */
    public function getHeight(): ?string
    {
        return $this->height;
    }

    /**
     * @param string|null $height
     */
    public function setHeight(?string $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }
}
