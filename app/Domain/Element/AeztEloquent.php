<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAeztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AeztEloquent",
 *     title="Aezt Eloquent",
 *     description="Aezt eloquent schema"
 * )
 */
class AeztEloquent extends BaseEloquent implements IAeztEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAeztEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'aezt', 'reason', 'init', 'aeztable_id', 'aeztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'aezt', 'reason', 'init', 'aeztable_id', 'aeztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'aezt', 'aeztable_id', 'aeztable_type',
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
     *     property="aezt",
     *     type="string",
     *     format="date-time",
     *     description="Aezt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAezt(): DateTime
    {
        return new DateTime($this->aezt);
    }

    public function setAezt(DateTime $aezt)
    {
        $this->aezt = Timezone::convertSetDatetime($aezt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="aeztable_id",
     *     type="integer",
     *     format="int64",
     *     description="Aeztable id property"
     * )
     */
    public function getAeztableId(): int
    {
        return $this->aeztable_id;
    }

    public function setAeztableId(int $aeztable_id)
    {
        $this->aeztable_id = $aeztable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="aeztable_type",
     *     type="string",
     *     description="Aeztable type property"
     * )
     */
    public function getAeztableType(): string
    {
        return $this->aeztable_type;
    }

    public function setAeztableType(string $aeztable_type)
    {
        $this->aeztable_type = $aeztable_type;
        return $this;
    }


    public function getAeztAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function aeztable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
