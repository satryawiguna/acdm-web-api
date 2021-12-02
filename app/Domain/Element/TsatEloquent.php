<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITsatEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @OA\Schema(
 *     schema="TsatEloquent",
 *     title="Tsat Eloquent",
 *     description="Tsat eloquent schema"
 * )
 */
class TsatEloquent extends BaseEloquent implements ITsatEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = ITsatEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'tsat', 'reason', 'init', 'tsatable_id', 'tsatable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'tsat', 'reason', 'init', 'tsatable_id', 'tsatable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'tsat', 'tsatable_id', 'tsatable_type',
        'created_at', 'updated_at'
    ];
    public $timestamps = false;

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
     *     property="departure_id",
     *     type="integer",
     *     format="int64",
     *     description="Departure id property"
     * )
     */
    public function getDepartureId(): int
    {
        return $this->departure_id;
    }

    public function setDepartureId(int $departure_id)
    {
        $this->departure_id = $departure_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="tsat",
     *     type="string",
     *     format="date-time",
     *     description="Tsat property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     *
     * @throws \Exception
     */
    public function getTsat(): DateTime
    {
        return new DateTime($this->tsat);
    }

    public function setTsat(DateTime $tsat)
    {
        $this->tsat = Timezone::convertSetDatetime($tsat->format(Config::get('datetime.format.database_datetime')));
        return $this;
    }

    /**
     * @OA\Property(
     *     property="reason",
     *     type="string",
     *     description="Reason property"
     * )
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    public function setReason(string $reason)
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="init",
     *     type="bool",
     *     description="Init property"
     * )
     */
    public function getInit(): bool
    {
        return $this->init;
    }

    public function setInit(bool $init)
    {
        $this->init = $init;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="tsatable_id",
     *     type="integer",
     *     format="int64",
     *     description="Tsatable id property"
     * )
     */
    public function getTsatableId(): int
    {
        return $this->tsatable_id;
    }

    public function setTsatableId(int $tsatable_id)
    {
        $this->tsatable_id = $tsatable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="tsatable_type",
     *     type="string",
     *     description="Tsatable type property"
     * )
     */
    public function getTsatableType(): string
    {
        return $this->tsatable_type;
    }

    public function setTsatableType(string $tsatable_type)
    {
        $this->tsatable_type = $tsatable_type;
        return $this;
    }


    public function getTsatAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function tsatable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
