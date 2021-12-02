<?php


namespace App\Domain\Departure;


use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Departure\IFlightInformationEloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="FlightInformationEloquent",
 *     title="Flight Information Eloquent",
 *     description="Flight information eloquent schema",
 * )
 */
class FlightInformationEloquent extends BaseEloquent implements IFlightInformationEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IFlightInformationEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'type', 'reason', 'role_id',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id', 'type', 'reason', 'role_id',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'departure_id',
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
     *     property="type",
     *     type="string",
     *     description="Type property"
     * )
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
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
     *     property="role_id",
     *     type="integer",
     *     format="int64",
     *     description="Role id property"
     * )
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function setRoleId(int $role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }

    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }

    public function role()
    {
        return $this->belongsTo(RoleEloquent::class, 'role_id');
    }
}
