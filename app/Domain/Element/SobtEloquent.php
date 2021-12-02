<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ISobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="SobtEloquent",
 *     title="Sobt Eloquent",
 *     description="Sobt eloquent schema"
 * )
 */
class SobtEloquent extends BaseEloquent implements ISobtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = ISobtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'sobt', 'reason', 'init', 'sobtable_id', 'sobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'sobt', 'reason', 'init', 'sobtable_id', 'sobtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'sobt', 'sobtable_id', 'sobtable_type',
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
     *     property="sobt",
     *     type="string",
     *     format="date-time",
     *     description="Sobt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getSobt(): DateTime
    {
        return new DateTime($this->sobt);
    }

    public function setSobt(DateTime $sobt)
    {
        $this->sobt = Timezone::convertSetDatetime($sobt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="sobtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Sobtable id property"
     * )
     */
    public function getSobtableId(): int
    {
        return $this->sobtable_id;
    }

    public function setSobtableId(int $sobtable_id)
    {
        $this->sobtable_id = $sobtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="sobtable_type",
     *     type="string",
     *     description="Sobtable type property"
     * )
     */
    public function getSobtableType(): string
    {
        return $this->sobtable_type;
    }

    public function setSobtableType(string $sobtable_type)
    {
        $this->sobtable_type = $sobtable_type;
        return $this;
    }


    public function getSobtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function sobtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
