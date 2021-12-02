<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Help\Domain\Timezone;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAcgtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="AcgtEloquent",
 *     title="Acgt Eloquent",
 *     description="Acgt eloquent schema"
 * )
 */
class AcgtEloquent extends BaseEloquent implements IAcgtEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAcgtEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'acgt', 'reason', 'init', 'acgtable_id', 'acgtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'acgt', 'reason', 'init', 'acgtable_id', 'acgtable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'acgt', 'acgtable_id', 'acgtable_type',
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
     *     property="acgt",
     *     type="string",
     *     format="date-time",
     *     description="Acgt property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     * @throws \Exception
     */
    public function getAcgt(): DateTime
    {
        return new DateTime($this->acgt);
    }

    public function setAcgt(DateTime $acgt)
    {
        $this->acgt = Timezone::convertSetDatetime($acgt->format(Config::get('datetime.format.database_datetime')));
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
     *     property="acgtable_id",
     *     type="integer",
     *     format="int64",
     *     description="Acgtable id property"
     * )
     */
    public function getAcgtableId(): int
    {
        return $this->acgtable_id;
    }

    public function setAcgtableId(int $acgtable_id)
    {
        $this->acgtable_id = $acgtable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="acgtable_type",
     *     type="string",
     *     description="Acgtable type property"
     * )
     */
    public function getAcgtableType(): string
    {
        return $this->acgtable_type;
    }

    public function setAcgtableType(string $acgtable_type)
    {
        $this->acgtable_type = $acgtable_type;
        return $this;
    }


    public function getAcgtAttribute($value)
    {
        return Timezone::convertGetDatetime($value);
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function acgtable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
