<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAegtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AegtEloquent",
 *     title="Aegt Eloquent",
 *     description="Aegt eloquent schema"
 * )
 */
class AegtEloquent extends BaseEloquent implements IAegtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAegtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'aegt', 'reason', 'init', 'aegtable_id', 'aegtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'aegt', 'reason', 'init', 'aegtable_id', 'aegtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'aegt', 'aegtable_id', 'aegtable_type',
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
     *     property="aegt",
     *     type="string",
     *     format="date-time",
     *     description="Aegt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAegt(): DateTime
    {
        return new DateTime($this->aegt);
    }

    public function setAegt(DateTime $aegt)
    {
        $this->aegt = Timezone::convertSetDatetime($aegt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="aegtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Aegtable id property"
     * )
     */
    public function getAegtableId(): int
    {
        return $this->aegtable_id;
    }

    public function setAegtableId(int $aegtable_id)
    {
        $this->aegtable_id = $aegtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="aegtable_type",
     *     type="string",
     *     description="Aegtable type property"
     * )
     */
    public function getAegtableType(): string
    {
        return $this->aegtable_type;
    }

    public function setAegtableType(string $aegtable_type)
    {
        $this->aegtable_type = $aegtable_type;
        return $this;
    }


    public function getAegtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function aegtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
