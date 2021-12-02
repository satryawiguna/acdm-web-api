<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAditEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="AditEloquent",
 *     title="Adit Eloquent",
 *     description="Adit eloquent schema",
 * )
 */
class AditEloquent extends BaseEloquent implements IAditEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAditEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'adit', 'reason', 'init', 'aditable_id', 'aditable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'adit', 'reason', 'init', 'aditable_id', 'aditable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'adit', 'aditable_id', 'aditable_type',
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
     *     property="adit",
     *     type="integer",
     *     format="int64",
     *     description="Adit property"
     * )
     */
    public function getAdit(): int
    {
        return $this->adit;
    }

    public function setAdit(int $adit)
    {
        $this->adit = $adit;
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
     *     property="aditable_id",
     *     type="integer",
     *     format="int64",
     *     description="Aditable id property"
     * )
     */
    public function getAditableId(): int
    {
        return $this->aditable_id;
    }

    public function setAditableId(int $aditable_id)
    {
        $this->aditable_id = $aditable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="aditable_type",
     *     type="string",
     *     description="Aditable type property"
     * )
     */
    public function getAditableType(): string
    {
        return $this->aditable_type;
    }

    public function setAditableType(string $aditable_type)
    {
        $this->aditable_type = $aditable_type;
        return $this;
    }



    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function aditable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
