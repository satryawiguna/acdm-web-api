<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AobtEloquent",
 *     title="Aobt Eloquent",
 *     description="Aobt eloquent schema"
 * )
 */
class AobtEloquent extends BaseEloquent implements IAobtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAobtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'aobt', 'reason', 'init', 'aobtable_id', 'aobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'aobt', 'reason', 'init', 'aobtable_id', 'aobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'aobt', 'aobtable_id', 'aobtable_type',
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
     *     property="aobt",
     *     type="string",
     *     format="date-time",
     *     description="Aobt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAobt(): DateTime
    {
        return new DateTime($this->aobt);
    }

    public function setAobt(DateTime $aobt)
    {
        $this->aobt = Timezone::convertSetDatetime($aobt->format(Config::get('datetime.format.database_datetime'))) ;
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
     *     property="aobtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Aobtable id property"
     * )
     */
    public function getAobtableId(): int
    {
        return $this->aobtable_id;
    }

    public function setAobtableId(int $aobtable_id)
    {
        $this->aobtable_id = $aobtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="aobtable_type",
     *     type="string",
     *     description="Aobtable type property"
     * )
     */
    public function getAobtableType(): string
    {
        return $this->aobtable_type;
    }

    public function setAobtableType(string $aobtable_type)
    {
        $this->aobtable_type = $aobtable_type;
        return $this;
    }


    public function getAobtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function aobtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
