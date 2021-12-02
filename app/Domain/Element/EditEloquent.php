<?php
namespace App\Domain\Element;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEditEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="EditEloquent",
 *     title="Edit Eloquent",
 *     description="Edit eloquent schema"
 * )
 */
class EditEloquent extends BaseEloquent implements IEditEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IEditEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'edit', 'reason', 'init', 'editable_id', 'editable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'edit', 'reason', 'init', 'editable_id', 'editable_type',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id', 'edit', 'editable_id', 'editable_type',
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
     *     property="edit",
     *     type="integer",
     *     format="int64",
     *     description="Edit property"
     * )
     */
    public function getEdit(): int
    {
        return $this->edit;
    }

    public function setEdit(int $edit)
    {
        $this->edit = $edit;
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
     *     property="editable_id",
     *     type="integer",
     *     format="int64",
     *     description="Editable id property"
     * )
     */
    public function getEditableId(): int
    {
        return $this->editable_id;
    }

    public function setEditableId(int $editable_id)
    {
        $this->editable_id = $editable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="editable_type",
     *     type="string",
     *     description="Editable type property"
     * )
     */
    public function getEditableType(): string
    {
        return $this->editable_type;
    }

    public function setEditableType(string $editable_type)
    {
        $this->editable_type = $editable_type;
        return $this;
    }


    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function editable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);
