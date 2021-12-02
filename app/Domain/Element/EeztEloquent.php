<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEeztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="EeztEloquent",
 *     title="Eezt Eloquent",
 *     description="Eezt eloquent schema"
 * )
 */
class EeztEloquent extends BaseEloquent implements IEeztEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IEeztEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'eezt', 'reason', 'init', 'eeztable_id', 'eeztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'eezt', 'reason', 'init', 'eeztable_id', 'eeztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'eezt', 'eeztable_id', 'eeztable_type',
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
     *     property="eezt",
     *     type="string",
     *     format="date-time",
     *     description="Eezt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getEezt(): DateTime
    {
        return new DateTime($this->eezt);
    }

    public function setEezt(DateTime $eezt)
    {
        $this->eezt = Timezone::convertSetDatetime($eezt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="eeztable_id",
     *     type="integer",
     *     format="int64",
     *     description="Eeztable id property"
     * )
     */
    public function getEeztableId(): int
    {
        return $this->eeztable_id;
    }

    public function setEeztableId(int $eeztable_id)
    {
        $this->eeztable_id = $eeztable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="eeztable_type",
     *     type="string",
     *     description="Eeztable type property"
     * )
     */
    public function getEeztableType(): string
    {
        return $this->eeztable_type;
    }

    public function setEeztableType(string $eeztable_type)
    {
        $this->eeztable_type = $eeztable_type;
        return $this;
    }


    public function getEeztAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function eeztable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
