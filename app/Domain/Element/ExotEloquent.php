<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IExotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="ExotEloquent",
 *     title="Exot Eloquent",
 *     description="Exot eloquent schema"
 * )
 */
class ExotEloquent extends BaseEloquent implements IExotEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IExotEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'exot', 'reason', 'init', 'exotable_id', 'exotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'exot', 'reason', 'init', 'exotable_id', 'exotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'exot', 'exotable_id', 'exotable_type',
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
     *     property="exot",
     *     type="integer",
     *     format="int64",
     *     description="Exot property"
     * )
     */
    public function getExot(): int
    {
        return $this->exot;
    }

    public function setExot(int $exot)
    {
        $this->exot = $exot;
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
     *     property="exotable_id",
     *     type="integer",
     *     format="int64",
     *     description="Exotable id property"
     * )
     */
    public function getExotableId(): int
    {
        return $this->exotable_id;
    }

    public function setExotableId(int $exotable_id)
    {
        $this->exotable_id = $exotable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="exotable_type",
     *     type="string",
     *     description="Exotable type property"
     * )
     */
    public function getExotableType(): string
    {
        return $this->exotable_type;
    }

    public function setExotableType(string $exotable_type)
    {
        $this->exotable_type = $exotable_type;
        return $this;
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function exotable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
