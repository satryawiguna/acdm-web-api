<?php


namespace App\Domain\MasterData;


use App\Domain\Media\MediaEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IOrganizationEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Media\IMediaEloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     schema="OrganizationEloquent",
 *     title="Organization Eloquent",
 *     description="Organization eloquent schema",
 *     required={"name", "slug", "country_id"}
 * )
 */
class OrganizationEloquent extends BaseEloquent implements IOrganizationEloquent
{
    protected $table = IOrganizationEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'country_id', 'description',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'name', 'slug',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'name', 'slug',
        'created_at', 'updated_at'
    ];
    public $timestamps = false;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="Id property",
     *     example=1
     * )
     */

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property"
     * )
     *
     * @return string
     * @var string
     */

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="slug",
     *     type="string",
     *     description="Slug property"
     * )
     *
     * @return string
     * @var string
     */

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="country_id",
     *     type="integer",
     *     format="int64",
     *     description="Country id property"
     * )
     *
     * @return int
     * @var int
     */

    public function getCountryId(): int
    {
        return $this->country_id;
    }

    public function setCountryId(int $country_id)
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description property"
     * )
     *
     * @return string
     * @var string
     */

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function media()
    {
        return $this->morphToMany(MediaEloquent::class,
            'mediable',
            'mediables',
            'mediable_id',
            'media_id');
    }

    public function country()
    {
        return $this->belongsTo(CountryEloquent::class, "country_id");
    }

    public function vendors()
    {
        return $this->hasMany(VendorEloquent::class, 'organization_id');
    }
}

Relation::morphMap([
    IMediaEloquent::MORPH_NAME => MediaEloquent::class
]);
