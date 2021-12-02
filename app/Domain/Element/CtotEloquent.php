<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ICtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="CtotEloquent",
 *     title="Ctot Eloquent",
 *     description="Ctot eloquent schema"
 * )
 */
class CtotEloquent extends BaseEloquent implements ICtotEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = ICtotEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'ctot', 'reason', 'init', 'ctotable_id', 'ctotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'ctot', 'reason', 'init', 'ctotable_id', 'ctotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'ctot', 'ctotable_id', 'ctotable_type',
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
     *     property="ctot",
     *     type="string",
     *     format="date-time",
     *     description="Ctot property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getCtot(): DateTime
    {
        return new DateTime($this->ctot);
    }

    public function setCtot(DateTime $ctot)
    {
        $this->ctot = Timezone::convertSetDatetime($ctot->format(Config::get('datetime.format.database_datetime')));
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
     *     property="ctotable_id",
     *     type="integer",
     *     format="int64",
     *     description="Ctotable id property"
     * )
     */
    public function getCtotableId(): int
    {
        return $this->ctotable_id;
    }

    public function setCtotableId(int $ctotable_id)
    {
        $this->ctotable_id = $ctotable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ctotable_type",
     *     type="string",
     *     description="Ctotable type property"
     * )
     */
    public function getCtotableType(): string
    {
        return $this->ctotable_type;
    }

    public function setCtotableType(string $ctotable_type)
    {
        $this->ctotable_type = $ctotable_type;
        return $this;
    }


    public function getCtotAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function ctotable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
