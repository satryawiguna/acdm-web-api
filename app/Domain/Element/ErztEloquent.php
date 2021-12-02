<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IErztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="ErztEloquent",
 *     title="Erzt Eloquent",
 *     description="Erzt eloquent schema"
 * )
 */
class ErztEloquent extends BaseEloquent implements IErztEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IErztEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'erzt', 'reason', 'init', 'erztable_id', 'erztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'erzt', 'reason', 'init', 'erztable_id', 'erztable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'erzt', 'erztable_id', 'erztable_type',
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
     *     property="erzt",
     *     type="string",
     *     format="date-time",
     *     description="Erzt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getErzt(): DateTime
    {
        return new DateTime($this->erzt);
    }

    public function setErzt(DateTime $erzt)
    {
        $this->erzt = Timezone::convertSetDatetime($erzt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="erztable_id",
     *     type="integer",
     *     format="int64",
     *     description="Erztable id property"
     * )
     */
    public function getErztableId(): int
    {
        return $this->erztable_id;
    }

    public function setErztableId(int $erztable_id)
    {
        $this->erztable_id = $erztable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="erztable_type",
     *     type="string",
     *     description="Erztable type property"
     * )
     */
    public function getErztableType(): string
    {
        return $this->erztable_type;
    }

    public function setErztableType(string $erztable_type)
    {
        $this->erztable_type = $erztable_type;
        return $this;
    }


    public function getErztAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function erztable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
