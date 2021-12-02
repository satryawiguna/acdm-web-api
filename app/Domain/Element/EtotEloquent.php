<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @OA\Schema(
 *     schema="EtotEloquent",
 *     title="Etot Eloquent",
 *     description="Etot eloquent schema"
 * )
 */
class EtotEloquent extends BaseEloquent implements IEtotEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IEtotEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'etot', 'reason', 'init', 'etotable_id', 'etotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'etot', 'reason', 'init', 'etotable_id', 'etotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'etot', 'etotable_id', 'etotable_type',
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
     *     property="etot",
     *     type="string",
     *     format="date-time",
     *     description="Etot property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getEtot(): DateTime
    {
        return new DateTime($this->etot);
    }

    public function setEtot(DateTime $etot)
    {
        $this->etot = Timezone::convertSetDatetime($etot->format(Config::get('datetime.format.database_datetime')));
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
     *     property="etotable_id",
     *     type="integer",
     *     format="int64",
     *     description="Etotable id property"
     * )
     */
    public function getEtotableId(): int
    {
        return $this->etotable_id;
    }

    public function setEtotableId(int $etotable_id)
    {
        $this->etotable_id = $etotable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="etotable_type",
     *     type="string",
     *     description="Etotable type property"
     * )
     */
    public function getEtotableType(): string
    {
        return $this->etotable_type;
    }

    public function setEtotableType(string $etotable_type)
    {
        $this->etotable_type = $etotable_type;
        return $this;
    }


    public function getEtotAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function etotable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
