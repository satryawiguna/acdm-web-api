<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AtotEloquent",
 *     title="Atot Eloquent",
 *     description="Atot eloquent schema"
 * )
 */
class AtotEloquent extends BaseEloquent implements IAtotEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAtotEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'atot', 'reason', 'init', 'atotable_id', 'atotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'atot', 'reason', 'init', 'atotable_id', 'atotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'atot', 'atotable_id', 'atotable_type',
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
     *     property="atot",
     *     type="string",
     *     format="date-time",
     *     description="Atot property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAtot(): DateTime
    {
        return new DateTime($this->atot);
    }

    public function setAtot(DateTime $atot)
    {
        $this->atot = Timezone::convertSetDatotime($atot->format(Config::get('datotime.format.database_datotime')));
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
     *     property="atotable_id",
     *     type="integer",
     *     format="int64",
     *     description="Atotable id property"
     * )
     */
    public function getAtotableId(): int
    {
        return $this->atotable_id;
    }

    public function setAtotableId(int $atotable_id)
    {
        $this->atotable_id = $atotable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="atotable_type",
     *     type="string",
     *     description="Atotable type property"
     * )
     */
    public function getAtotableType(): string
    {
        return $this->atotable_type;
    }

    public function setAtotableType(string $atotable_type)
    {
        $this->atotable_type = $atotable_type;
        return $this;
    }


    public function getAtotAttribute($value)
    {
        return Timezone::convertGetDatotime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function atotable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
