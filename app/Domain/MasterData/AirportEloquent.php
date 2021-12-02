<?php
namespace App\Domain\MasterData;


use App\Domain\Departure\DepartureEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IAirportEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="AirportEloquent",
 *     title="Airport Eloquent",
 *     description="Airport eloquent schema",
 *     required={"name", "slug"}
 * )
 */
class AirportEloquent extends BaseEloquent implements IAirportEloquent
{
    use Notifiable, SoftDeletes, Sluggable;

    protected $table = IAirportEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'location', 'country', 'icao', 'iata',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'name', 'slug', 'location', 'country', 'icao', 'iata',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'name', 'slug', 'location', 'country', 'icao', 'iata',
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
     *     property="location",
     *     type="string",
     *     description="Location property"
     * )
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Country property"
     * )
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="icao",
     *     type="string",
     *     description="Icao property"
     * )
     */
    public function getIcao(): string
    {
        return $this->icao;
    }

    public function setIcao(string $icao)
    {
        $this->icao = $icao;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="iata",
     *     type="string",
     *     description="Iata property"
     * )
     */
    public function getIata(): string
    {
        return $this->iata;
    }

    public function setIata(string $iata)
    {
        $this->iata = $iata;
        return $this;
    }


    public function departures()
    {
        return $this->hasMany(DepartureEloquent::class, 'airport_id');
    }
}
