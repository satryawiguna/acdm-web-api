<?php
namespace App\Domain\MasterData;


use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IAirlineEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="AirlineEloquent",
 *     title="Airline Eloquent",
 *     description="Airline eloquent schema",
 *     required={"name", "slug"}
 * )
 */
class AirlineEloquent extends BaseEloquent implements IAirlineEloquent
{
    use Notifiable, SoftDeletes, Sluggable;

    protected $table = IAirlineEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'flight_number', 'name', 'slug', 'icao', 'iata', 'call_sign',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'flight_number', 'name', 'slug', 'icao', 'iata', 'call_sign',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'flight_number', 'name', 'slug', 'icao', 'iata', 'call_sign',
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
     *     property="flight_number",
     *     type="string",
     *     description="Flight number property"
     * )
     *
     * @return string
     * @var string
     */

    public function getFlightNumber(): string
    {
        return $this->flight_number;
    }

    public function setFlightNumber(string $flight_number)
    {
        $this->flight_number = $flight_number;
        return $this;
    }

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
     *     property="icao",
     *     type="string",
     *     description="Icao property"
     * )
     *
     * @return string
     * @var string
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
     *
     * @return string
     * @var string
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

    /**
     * @OA\Property(
     *     property="call_sign",
     *     type="string",
     *     description="Call sign property"
     * )
     *
     * @return string
     * @var string
     */

    public function getCallSign(): string
    {
        return $this->call_sign;
    }

    public function setCallSign(string $call_sign)
    {
        $this->call_sign = $call_sign;
        return $this;
    }
}
