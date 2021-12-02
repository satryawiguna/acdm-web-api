<?php
namespace App\Domain\Media;


use App\Domain\MasterData\OrganizationEloquent;
use App\Domain\Membership\ProfileEloquent;
use App\Help\Domain\Uuid;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IOrganizationEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Media\IMediaEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IProfileEloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="MediaEloquent",
 *     title="Media Eloquent",
 *     description="Media eloquent schema",
 *     required={"user_id", "collection", "original_name", "generate_name"}
 * )
 */
class MediaEloquent extends BaseEloquent implements IMediaEloquent
{
    use Notifiable, Uuid;

    protected $table = IMediaEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'user_id', 'collection', 'original_name', 'generate_name', 'extension', 'mime_type', 'path', 'url', 'width', 'height', 'size',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'user_id', 'collection', 'original_name', 'extension', 'mime_type', 'width', 'height', 'size',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'user_id', 'original_file', 'extension', 'mime_type', 'width', 'height', 'size',
        'created_at', 'updated_at'
    ];
    public $timestamps = false;

    /**
     * @OA\Property(
     *     property="id",
     *     type="string",
     *     description="Id property"
     * )
     */

    /**
     * @OA\Property(
     *     property="user_id",
     *     type="integer",
     *     type="int64",
     *     description="User id property"
     * )
     */

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="collection",
     *     type="string",
     *     description="Collection property"
     * )
     */
    public function getCollection(): string
    {
        return $this->collection;
    }

    public function setCollection(string $collection)
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="original_name",
     *     type="string",
     *     description="Original name property"
     * )
     */
    public function getOriginalName(): string
    {
        return $this->original_name;
    }

    public function setOriginalName(string $original_name)
    {
        $this->original_name = $original_name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="generate_name",
     *     type="string",
     *     description="Generate name property"
     * )
     */
    public function getGenerateName(): string
    {
        return $this->generate_name;
    }

    public function setGenerateName(string $generate_name)
    {
        $this->generate_name = $generate_name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="extension",
     *     type="string",
     *     description="Extension property"
     * )
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="mime_type",
     *     type="string",
     *     description="Mime type property"
     * )
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type)
    {
        $this->mime_type = $mime_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="path",
     *     type="string",
     *     description="Path property"
     * )
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="url",
     *     type="string",
     *     description="Url property"
     * )
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="width",
     *     type="integer",
     *     type="int32",
     *     description="Width property"
     * )
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width)
    {
        $this->width = width;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="height",
     *     type="integer",
     *     type="int32",
     *     description="Height property"
     * )
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="size",
     *     type="integer",
     *     type="int32",
     *     description="Size property"
     * )
     */
    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    public function profiles()
    {
        return $this->morphedByMany(ProfileEloquent::class,
            'mediable');
    }

    public function organizations()
    {
        return $this->morphedByMany(OrganizationEloquent::class, 'mediable');
    }
}

Relation::morphMap([
    IProfileEloquent::MORPH_NAME => ProfileEloquent::class,
    IOrganizationEloquent::MORPH_NAME => OrganizationEloquent::class
]);
