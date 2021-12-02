<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IArdtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="ArdtEloquent",
 *     title="Ardt Eloquent",
 *     description="Ardt eloquent schema",
 * )
 */
class ArdtEloquent extends BaseEloquent implements IArdtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IArdtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'ardt', 'reason', 'init', 'ardtable_id', 'ardtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'ardt', 'reason', 'init', 'ardtable_id', 'ardtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'ardt', 'ardtable_id', 'ardtable_type',
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
     *     property="ardt",
     *     type="string",
     *     format="date-time",
     *     description="Ardt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getArdt(): DateTime
    {
        return new DateTime($this->ardt);
    }

    public function setArdt(DateTime $ardt)
    {
        $this->ardt = Timezone::convertSetDatetime($ardt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="ardtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Ardtable id property"
     * )
     */
    public function getArdtableId(): int
    {
        return $this->ardtable_id;
    }

    public function setArdtableId(int $ardtable_id)
    {
        $this->ardtable_id = $ardtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ardtable_type",
     *     type="string",
     *     description="Ardtable type property"
     * )
     */
    public function getArdtableType(): string
    {
        return $this->ardtable_type;
    }

    public function setArdtableType(string $ardtable_type)
    {
        $this->ardtable_type = $ardtable_type;
        return $this;
    }


    public function getArdtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function ardtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
