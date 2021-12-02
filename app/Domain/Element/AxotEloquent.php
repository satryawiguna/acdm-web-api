<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAxotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @OA\Schema(
 *     schema="AxotEloquent",
 *     title="Axot Eloquent",
 *     description="Axot eloquent schema"
 * )
 */
class AxotEloquent extends BaseEloquent implements IAxotEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAxotEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'axot', 'reason', 'init', 'axotable_id', 'axotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'axot', 'reason', 'init', 'axotable_id', 'axotable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'axot', 'axotable_id', 'axotable_type',
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
     *     property="axot",
     *     type="integer",
     *     format="int64",
     *     description="Axot property"
     * )
     */
    public function getAxot(): int
    {
        return $this->axot;
    }

    public function setAxot(int $axot)
    {
        $this->axot = $axot;
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
     *     property="axotable_id",
     *     type="integer",
     *     format="int64",
     *     description="Axotable id property"
     * )
     */
    public function getAxotableId(): int
    {
        return $this->axotable_id;
    }

    public function setAxotableId(int $axotable_id)
    {
        $this->axotable_id = $axotable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="axotable_type",
     *     type="string",
     *     description="Axotable type property"
     * )
     */
    public function getAxotableType(): string
    {
        return $this->axotable_type;
    }

    public function setAxotableType(string $axotable_type)
    {
        $this->axotable_type = $axotable_type;
        return $this;
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function axotable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
