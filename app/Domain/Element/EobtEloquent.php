<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="EobtEloquent",
 *     title="Eobt Eloquent",
 *     description="Eobt eloquent schema",
 *     required={"departure_id", "eobt", "role_initialize_id", "role_origin_id"}
 * )
 */
class EobtEloquent extends BaseEloquent implements IEobtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IEobtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'eobt', 'reason', 'init', 'eobtable_id', 'eobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'eobt', 'reason', 'init', 'eobtable_id', 'eobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'eobt', 'eobtable_id', 'eobtable_type',
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
     *     property="eobt",
     *     type="string",
     *     format="date-time",
     *     description="Eobt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getEobt(): DateTime
    {
        return new DateTime($this->eobt);
    }

    public function setEobt(DateTime $eobt)
    {
        $this->eobt = Timezone::convertSetDatetime($eobt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="eobtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Eobtable id property"
     * )
     */
    public function getEobtableId(): int
    {
        return $this->eobtable_id;
    }

    public function setEobtableId(int $eobtable_id)
    {
        $this->eobtable_id = $eobtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="eobtable_type",
     *     type="string",
     *     description="Eobtable type property"
     * )
     */
    public function getEobtableType(): string
    {
        return $this->eobtable_type;
    }

    public function setEobtableType(string $eobtable_type)
    {
        $this->eobtable_type = $eobtable_type;
        return $this;
    }


    public function getEobtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function eobtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
