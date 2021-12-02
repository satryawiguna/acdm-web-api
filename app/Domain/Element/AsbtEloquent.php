<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAsbtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AsbtEloquent",
 *     title="Asbt Eloquent",
 *     description="Asbt eloquent schema"
 * )
 */
class AsbtEloquent extends BaseEloquent implements IAsbtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAsbtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'asbt', 'reason', 'init', 'asbtable_id', 'asbtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'asbt', 'reason', 'init', 'asbtable_id', 'asbtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'asbt', 'asbtable_id', 'asbtable_type',
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
     *     property="asbt",
     *     type="string",
     *     format="date-time",
     *     description="Asbt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAsbt(): DateTime
    {
        return new DateTime($this->asbt);
    }

    public function setAsbt(DateTime $asbt)
    {
        $this->asbt = Timezone::convertSetDatetime($asbt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="asbtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Asbtable id property"
     * )
     */
    public function getAsbtableId(): int
    {
        return $this->asbtable_id;
    }

    public function setAsbtableId(int $asbtable_id)
    {
        $this->asbtable_id = $asbtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="asbtable_type",
     *     type="string",
     *     description="Asbtable type property"
     * )
     */
    public function getAsbtableType(): string
    {
        return $this->asbtable_type;
    }

    public function setAsbtableType(string $asbtable_type)
    {
        $this->asbtable_type = $asbtable_type;
        return $this;
    }


    public function getAsbtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function asbtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
