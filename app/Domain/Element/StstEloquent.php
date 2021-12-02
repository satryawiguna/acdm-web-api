<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IStstEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="StstEloquent",
 *     title="Stst Eloquent",
 *     description="Stst eloquent schema"
 * )
 */
class StstEloquent extends BaseEloquent implements IStstEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IStstEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'stst', 'reason', 'init', 'ststable_id', 'ststable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'stst', 'reason', 'init', 'ststable_id', 'ststable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'stst', 'ststable_id', 'ststable_type',
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
     *     property="stst",
     *     type="string",
     *     format="date-time",
     *     description="Stst property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     *
     * @return DateTime
     * @throws \Exception
     */

    public function getStst(): DateTime
    {
        return new DateTime($this->stst);
    }

    public function setStst(DateTime $stst)
    {
        $this->stst = Timezone::convertSetDatetime($stst->format(Config::get('datetime.format.database_datetime')));
        return $this;
    }

    /**
     * @OA\Property(
     *     property="reason",
     *     type="string",
     *     description="Reason property"
     * )
     *
     * @return string
     * @var string
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
     *     property="ststable_id",
     *     type="integer",
     *     format="int64",
     *     description="Ststable id property"
     * )
     */
    public function getStstableId(): int
    {
        return $this->ststable_id;
    }

    public function setStstableId(int $ststable_id)
    {
        $this->ststable_id = $ststable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ststable_type",
     *     type="string",
     *     description="Ststable type property"
     * )
     */
    public function getStstableType(): string
    {
        return $this->ststable_type;
    }

    public function setStstableType(string $ststable_type)
    {
        $this->ststable_type = $ststable_type;
        return $this;
    }


    public function getStstAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function ststable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
