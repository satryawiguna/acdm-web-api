<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IArztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="ArztEloquent",
 *     title="Arzt Eloquent",
 *     description="Arzt eloquent schema"
 * )
 */
class ArztEloquent extends BaseEloquent implements IArztEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IArztEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'arzt', 'reason', 'init', 'arztable_id', 'arztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'arzt', 'reason', 'init', 'arztable_id', 'arztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'arzt', 'arztable_id', 'arztable_type',
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
     *     property="arzt",
     *     type="string",
     *     format="date-time",
     *     description="Arzt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getArzt(): DateTime
    {
        return new DateTime($this->arzt);
    }

    public function setArzt(DateTime $arzt)
    {
        $this->arzt = Timezone::convertSetDatetime($arzt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="arztable_id",
     *     type="integer",
     *     format="int64",
     *     description="Arztable id property"
     * )
     */
    public function getArztableId(): int
    {
        return $this->arztable_id;
    }

    public function setArztableId(int $arztable_id)
    {
        $this->arztable_id = $arztable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="arztable_type",
     *     type="string",
     *     description="Arztable type property"
     * )
     */
    public function getArztableType(): string
    {
        return $this->arztable_type;
    }

    public function setArztableType(string $arztable_type)
    {
        $this->arztable_type = $arztable_type;
        return $this;
    }


    public function getArztAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function arztable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
