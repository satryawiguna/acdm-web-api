<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEcztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="EcztEloquent",
 *     title="Eczt Eloquent",
 *     description="Eczt eloquent schema"
 * )
 */
class EcztEloquent extends BaseEloquent implements IEcztEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IEcztEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'eczt', 'reason', 'init', 'ecztable_id', 'ecztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'eczt', 'reason', 'init', 'ecztable_id', 'ecztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'eczt', 'ecztable_id', 'ecztable_type',
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
     *     property="eczt",
     *     type="string",
     *     format="date-time",
     *     description="Eczt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getEczt(): DateTime
    {
        return new DateTime($this->eczt);
    }

    public function setEczt(DateTime $eczt)
    {
        $this->eczt = Timezone::convertSetDatetime($eczt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="ecztable_id",
     *     type="integer",
     *     format="int64",
     *     description="Ecztable id property"
     * )
     */
    public function getEcztableId(): int
    {
        return $this->ecztable_id;
    }

    public function setEcztableId(int $ecztable_id)
    {
        $this->ecztable_id = $ecztable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ecztable_type",
     *     type="string",
     *     description="Ecztable type property"
     * )
     */
    public function getEcztableType(): string
    {
        return $this->ecztable_type;
    }

    public function setEcztableType(string $ecztable_type)
    {
        $this->ecztable_type = $ecztable_type;
        return $this;
    }


    public function getEcztAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function ecztable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
