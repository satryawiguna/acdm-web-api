<?php


namespace App\Domain\MasterData;


use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\ICountryEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     schema="CountryEloquent",
 *     title="Country Eloquent",
 *     description="Country eloquent schema",
 *     required={"name", "slug"}
 * )
 */
class CountryEloquent extends BaseEloquent implements ICountryEloquent
{
    use Notifiable, SoftDeletes, Sluggable;

    protected $table = ICountryEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'calling_code', 'iso_code_two_digit', 'iso_code_three_digit',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'name', 'slug', 'calling_code', 'iso_code_two_digit', 'iso_code_three_digit',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'name', 'slug', 'calling_code', 'iso_code_two_digit', 'iso_code_three_digit',
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
     *     property="calling_code",
     *     type="string",
     *     description="Calling code property"
     * )
     *
     * @return string
     * @var string
     */

    public function getCallingCode(): string
    {
        return $this->calling_code;
    }

    public function setCallingCode(string $calling_code)
    {
        $this->calling_code = $calling_code;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="iso_code_two_digit",
     *     type="string",
     *     description="ISO code two digit property"
     * )
     *
     * @return string
     * @var string
     */

    public function getIsoCodeTwoDigit(): string
    {
        return $this->iso_code_two_digit;
    }

    public function setIsoCodeTwoDigit(string $iso_code_two_digit)
    {
        $this->iso_code_two_digit = $iso_code_two_digit;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="iso_code_three_digit",
     *     type="string",
     *     description="ISO code three digit property"
     * )
     *
     * @return string
     * @var string
     */

    public function getIsoCodeThreeDigit(): string
    {
        return $this->iso_code_three_digit;
    }

    public function setIsoCodeThreeDigit(string $iso_code_three_digit)
    {
        $this->iso_code_three_digit = $iso_code_three_digit;
        return $this;
    }


    public function organizations()
    {
        return $this->hasMany(OrganizationEloquent::class, "country_id");
    }
}
