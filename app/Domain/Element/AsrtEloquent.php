<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAsrtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AsrtEloquent",
 *     title="Asrt Eloquent",
 *     description="Asrt eloquent schema"
 * )
 */
class AsrtEloquent extends BaseEloquent implements IAsrtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAsrtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'asrt', 'reason', 'init', 'asrtable_id', 'asrtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'asrt', 'reason', 'init', 'asrtable_id', 'asrtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'asrt', 'asrtable_id', 'asrtable_type',
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
     *     property="asrt",
     *     type="string",
     *     format="date-time",
     *     description="Asrt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAsrt(): DateTime
    {
        return new DateTime($this->asrt);
    }

    public function setAsrt(DateTime $asrt)
    {
        $this->asrt = Timezone::convertSetDatetime($asrt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="asrtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Asrtable id property"
     * )
     */
    public function getAsrtableId(): int
    {
        return $this->asrtable_id;
    }

    public function setAsrtableId(int $asrtable_id)
    {
        $this->asrtable_id = $asrtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="asrtable_type",
     *     type="string",
     *     description="Asrtable type property"
     * )
     */
    public function getAsrtableType(): string
    {
        return $this->asrtable_type;
    }

    public function setAsrtableType(string $asrtable_type)
    {
        $this->asrtable_type = $asrtable_type;
        return $this;
    }


    public function getAsrtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function asrtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
