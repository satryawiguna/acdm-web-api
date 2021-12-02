<?php
namespace App\Domain\Departure;


use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Departure\IDepartureMetaEloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="DepartureMetaEloquent",
 *     title="Departure Meta Eloquent",
 *     description="Departure meta eloquent schema",
 * )
 */
class DepartureMetaEloquent extends BaseEloquent implements IDepartureMetaEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IDepartureMetaEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'departure_id', 'flight', 'sobt', 'eobt', 'tobt', 'aegt', 'ardt', 'aobt', 'tsat', 'ttot', 'atot',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'departure_id',
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
     *     property="flight",
     *     type="object",
     *     description="Flight property",
     *     example="{""priority"":{""icon"":null,""type"":null,""blink"":null},""tickmark"":{""icon"":null,""blink"":null,""color"":null},""acknowledge"":false}"
     * )
     */
    public function getFlight(): object
    {
        return $this->flight;
    }

    public function setFlight(object $flight)
    {
        $this->flight = $flight;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="sobt",
     *     type="object",
     *     description="Sobt property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getSobt(): object
    {
        return $this->sobt;
    }

    public function setSobt(object $sobt)
    {
        $this->sobt = $sobt;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="eobt",
     *     type="object",
     *     description="Eobt property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getEobt(): object
    {
        return $this->eobt;
    }

    public function setEobt(object $eobt)
    {
        $this->eobt = $eobt;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="tobt",
     *     type="object",
     *     description="Tobt property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getTobt(): object
    {
        return $this->tobt;
    }

    public function setTobt(object $tobt)
    {
        $this->tobt = $tobt;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="aegt",
     *     type="object",
     *     description="Aegt property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getAegt(): object
    {
        return $this->aegt;
    }

    public function setAegt(object $aegt)
    {
        $this->aegt = $aegt;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ardt",
     *     type="object",
     *     description="Ardt property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getArdt(): object
    {
        return $this->ardt;
    }

    public function setArdt(object $ardt)
    {
        $this->ardt = $ardt;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="aobt",
     *     type="object",
     *     description="Aobt property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getAobt(): object
    {
        return $this->aobt;
    }

    public function setAobt(object $aobt)
    {
        $this->aobt = $aobt;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="tsat",
     *     type="object",
     *     description="Tsat property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getTsat(): object
    {
        return $this->tsat;
    }

    public function setTsat(object $tsat)
    {
        $this->tsat = $tsat;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="ttot",
     *     type="object",
     *     description="Ttot property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getTtot(): object
    {
        return $this->ttot;
    }

    public function setTtot(object $ttot)
    {
        $this->ttot = $ttot;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="atot",
     *     type="object",
     *     description="Atot property",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public function getAtot(): object
    {
        return $this->atot;
    }

    public function setAtot(object $atot)
    {
        $this->atot = $atot;
        return $this;
    }

    public function departure()
    {
        return $this->belongsTo(DepartureEloquent::class, 'departure_id');
    }
}
