<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="TtotEloquent",
 *     title="Ttot Eloquent",
 *     description="Ttot eloquent schema"
 * )
 */
class TtotEloquent extends BaseEloquent implements ITtotEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = ITtotEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'ttot', 'reason', 'init', 'ttotable_id', 'ttotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'ttot', 'reason', 'init', 'ttotable_id', 'ttotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'ttot', 'ttotable_id', 'ttotable_type',
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
     *     property="ttot",
     *     type="string",
     *     format="date-time",
     *     description="Ttot property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     *
     * @throws \Exception
     */
    public function getTtot(): DateTime
    {
        return new DateTime($this->ttot);
    }

    public function setTtot(DateTime $ttot)
    {
        $this->ttot = Timezone::convertSetDatetime($ttot->format(Config::get('datetime.format.database_datetime')));
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
     *     property="ttotable_id",
     *     type="integer",
     *     format="int64",
     *     description="Ttotable id property"
     * )
     */
    public function getTtotableId(): int
    {
        return $this->ttotable_id;
    }

    public function setTtotableId(int $ttotable_id)
    {
        $this->ttotable_id = $ttotable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ttotable_type",
     *     type="string",
     *     description="Ttotable type property"
     * )
     */
    public function getTtotableType(): string
    {
        return $this->ttotable_type;
    }

    public function setTtotableType(string $ttotable_type)
    {
        $this->ttotable_type = $ttotable_type;
        return $this;
    }


    public function getTtotAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function ttotable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
