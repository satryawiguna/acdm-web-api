<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtttEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="AtttEloquent",
 *     title="Attt Eloquent",
 *     description="Attt eloquent schema"
 * )
 */
class AtttEloquent extends BaseEloquent implements IAtttEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IAtttEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'attt', 'reason', 'init', 'atttable_id', 'atttable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'attt', 'reason', 'init', 'atttable_id', 'atttable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'attt', 'atttable_id', 'atttable_type',
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
     *     property="attt",
     *     type="integer",
     *     format="int64",
     *     description="Attt property"
     * )
     */
    public function getAttt(): int
    {
        return $this->attt;
    }

    public function setAttt(int $attt)
    {
        $this->attt = $attt;
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
     *     property="atttable_id",
     *     type="integer",
     *     format="int64",
     *     description="Atttable id property"
     * )
     */
    public function getAtttableId(): int
    {
        return $this->atttable_id;
    }

    public function setAtttableId(int $atttable_id)
    {
        $this->atttable_id = $atttable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="atttable_type",
     *     type="string",
     *     description="Atttable type property"
     * )
     */
    public function getAtttableType(): string
    {
        return $this->atttable_type;
    }

    public function setAtttableType(string $atttable_type)
    {
        $this->atttable_type = $atttable_type;
        return $this;
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function atttable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
