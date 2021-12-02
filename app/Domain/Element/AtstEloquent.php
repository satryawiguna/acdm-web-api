<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtstEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AtstEloquent",
 *     title="Atst Eloquent",
 *     description="Atst eloquent schema"
 * )
 */
class AtstEloquent extends BaseEloquent implements IAtstEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAtstEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'atst', 'reason', 'init', 'atstable_id', 'atstable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'atst', 'reason', 'init', 'atstable_id', 'atstable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'atst', 'atstable_id', 'atstable_type',
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
     *     property="atst",
     *     type="string",
     *     format="date-time",
     *     description="Atst property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAtst(): DateTime
    {
        return new DateTime($this->atst);
    }

    public function setAtst(DateTime $atst)
    {
        $this->atst = Timezone::convertSetDatetime($atst->format(Config::get('datetime.format.database_datetime')));
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
     *     property="atstable_id",
     *     type="integer",
     *     format="int64",
     *     description="Atstable id property"
     * )
     */
    public function getAtstableId(): int
    {
        return $this->atstable_id;
    }

    public function setAtstableId(int $atstable_id)
    {
        $this->atstable_id = $atstable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="atstable_type",
     *     type="string",
     *     description="Atstable type property"
     * )
     */
    public function getAtstableType(): string
    {
        return $this->atstable_type;
    }

    public function setAtstableType(string $atstable_type)
    {
        $this->atstable_type = $atstable_type;
        return $this;
    }


    public function getAtstAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function atstable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
