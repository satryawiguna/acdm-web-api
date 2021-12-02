<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="TobtEloquent",
 *     title="Tobt Eloquent",
 *     description="Tobt eloquent schema"
 * )
 */
class TobtEloquent extends BaseEloquent implements ITobtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = ITobtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'tobt', 'reason', 'init', 'tobtable_id', 'tobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'tobt', 'reason', 'init', 'tobtable_id', 'tobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'tobt', 'tobtable_id', 'tobtable_type',
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
     *     property="tobt",
     *     type="string",
     *     format="date-time",
     *     description="Tobt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getTobt(): DateTime
    {
        return new DateTime($this->tobt);
    }

    public function setTobt(DateTime $tobt)
    {
        $this->tobt = Timezone::convertSetDatetime($tobt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="tobtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Tobtable id property"
     * )
     */
    public function getTobtableId(): int
    {
        return $this->tobtable_id;
    }

    public function setTobtableId(int $tobtable_id)
    {
        $this->tobtable_id = $tobtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="tobtable_type",
     *     type="string",
     *     description="Tobtable type property"
     * )
     */
    public function getTobtableType(): string
    {
        return $this->tobtable_type;
    }

    public function setTobtableType(string $tobtable_type)
    {
        $this->tobtable_type = $tobtable_type;
        return $this;
    }


    public function getTobtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function tobtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
