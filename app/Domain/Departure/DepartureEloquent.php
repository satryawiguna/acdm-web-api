<?php
namespace App\Domain\Departure;


use App\Domain\Element\AcgtEloquent;
use App\Domain\Element\AcztEloquent;
use App\Domain\Element\AditEloquent;
use App\Domain\Element\AegtEloquent;
use App\Domain\Element\AeztEloquent;
use App\Domain\Element\AghtEloquent;
use App\Domain\Element\AobtEloquent;
use App\Domain\Element\ArdtEloquent;
use App\Domain\Element\ArztEloquent;
use App\Domain\Element\AsbtEloquent;
use App\Domain\Element\AsrtEloquent;
use App\Domain\Element\AtetEloquent;
use App\Domain\Element\AtotEloquent;
use App\Domain\Element\AtstEloquent;
use App\Domain\Element\AtttEloquent;
use App\Domain\Element\AxotEloquent;
use App\Domain\Element\AzatEloquent;
use App\Domain\Element\CtotEloquent;
use App\Domain\Element\EcztEloquent;
use App\Domain\Element\EditEloquent;
use App\Domain\Element\EeztEloquent;
use App\Domain\Element\EobtEloquent;
use App\Domain\Element\EtotEloquent;
use App\Domain\Element\ExotEloquent;
use App\Domain\Element\SobtEloquent;
use App\Domain\Element\StetEloquent;
use App\Domain\Element\StstEloquent;
use App\Domain\Element\TobtEloquent;
use App\Domain\Element\TsatEloquent;
use App\Domain\Element\TtotEloquent;
use App\Domain\MasterData\AirportEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Departure\IDepartureEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="DepartureEloquent",
 *     title="Departure Eloquent",
 *     description="Departure eloquent schema"
 * )
 */
class DepartureEloquent extends BaseEloquent implements IDepartureEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IDepartureEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'aodb_id', 'airport_id',
        'flight_number', 'flight_reason', 'flight_numberable_id', 'flight_numberable_type', 'flight_numberable_name',
        'call_sign',
        'nature', 'natureable_id', 'natureable_type', 'natureable_name',
        'acft', 'acftable_id', 'acftable_type', 'acftable_name',
        'register', 'registerable_id', 'registerable_type', 'registerable_name',
        'stand', 'standable_id', 'standable_type', 'standable_name',
        'gate_name', 'gate_nameable_id', 'gate_nameable_type', 'gate_nameable_name',
        'gate_open', 'gate_openable_id', 'gate_openable_type', 'gate_openable_name',
        'runway_actual', 'runway_actualable_id', 'runway_actualable_type', 'runway_actualable_name',
        'runway_estimated', 'runway_estimatedable_id', 'runway_estimatedable_type', 'runway_estimatedable_name',
        'transit', 'transitable_id', 'transitable_type', 'transitable_name',
        'destination', 'destinationable_id', 'destinationable_type', 'destinationable_name',
        'status', 'code_share',
        'data_origin',
        'data_originable_id', 'data_originable_type', 'data_originable_name',
        'sobt', 'eobt', 'tobt', 'aegt', 'ardt', 'tsat', 'aobt', 'acgt', 'ttot', 'atot', 'tobt_init',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'aodb_id', 'airport_id',
        'flight_number', 'flight_reason', 'flight_numberable_id', 'flight_numberable_type', 'flight_numberable_name',
        'call_sign',
        'nature', 'natureable_id', 'natureable_type', 'natureable_name',
        'acft', 'acftable_id', 'acftable_type', 'acftable_name',
        'register', 'registerable_id', 'registerable_type', 'registerable_name',
        'stand', 'standable_id', 'standable_type', 'standable_name',
        'gate_name', 'gate_nameable_id', 'gate_nameable_type', 'gate_nameable_name',
        'gate_open', 'gate_openable_id', 'gate_openable_type', 'gate_openable_name',
        'runway_actual', 'runway_actualable_id', 'runway_actualable_type', 'runway_actualable_name',
        'runway_estimated', 'runway_estimatedable_id', 'runway_estimatedable_type', 'runway_estimatedable_name',
        'transit', 'transitable_id', 'transitable_type', 'transitable_name',
        'destination', 'destinationable_id', 'destinationable_type', 'destinationable_name',
        'status', 'code_share',
        'data_origin',
        'data_originable_id', 'data_originable_type', 'data_originable_name',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'aodb_id',
        'flight_number', 'flight_reason',
        'call_sign',
        'nature',
        'acft',
        'register',
        'stand',
        'gate_name',
        'gate_open',
        'runway_actual',
        'runway_estimated',
        'transit',
        'destination',
        'status', 'code_share',
        'data_origin',
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
     *     property="aodb_id",
     *     type="integer",
     *     format="int64",
     *     description="Aodb id property"
     * )
     */
    public function getAodbId(): int
    {
        return $this->aodb_id;
    }

    public function setAodbId(int $aodb_id)
    {
        $this->aodb_id = $aodb_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="airport_id",
     *     type="integer",
     *     format="int64",
     *     description="Airport id property"
     * )
     */
    public function getAirportId(): int
    {
        return $this->airport_id;
    }

    public function setAirportId(int $airport_id)
    {
        $this->airport_id = $airport_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="airline_id",
     *     type="integer",
     *     format="int64",
     *     description="Airline id property"
     * )
     */
    public function getAirlineId(): int
    {
        return $this->airline_id;
    }

    public function setAirlineId(int $airline_id)
    {
        $this->airline_id = $airline_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="flight_number",
     *     type="string",
     *     description="Flight number property"
     * )
     */
    public function getFlightNumber(): string
    {
        return $this->flight_number;
    }

    public function setFlightNumber(string $flight_number)
    {
        $this->flight_number = $flight_number;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="flight_numberable_id",
     *     type="integer",
     *     format="int32",
     *     description="Flight numberable id property"
     * )
     */
    public function getFlightNumberableId(): int
    {
        return $this->flight_numberable_id;
    }

    public function setFlightNumberableId(int $flight_numberable_id)
    {
        $this->flight_numberable_id = $flight_numberable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="flight_numberable_type",
     *     type="string",
     *     description="Flight numberable type property"
     * )
     */
    public function getFlightNumberableType(): string
    {
        return $this->flight_numberable_type;
    }

    public function setFlightNumberableType(string $flight_numberable_type)
    {
        $this->flight_numberable_type = $flight_numberable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="call_sign",
     *     type="string",
     *     description="Call sign property"
     * )
     */
    public function getCallSign(): string
    {
        return $this->call_sign;
    }

    public function setCallSign(string $call_sign)
    {
        $this->call_sign = $call_sign;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="nature",
     *     type="string",
     *     description="Nature property"
     * )
     */
    public function getNature(): string
    {
        return $this->nature;
    }

    public function setNature(string $nature)
    {
        $this->nature = $nature;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="natureable_id",
     *     type="integer",
     *     format="int32",
     *     description="Natureable id property"
     * )
     */
    public function getNatureableId(): int
    {
        return $this->natureable_id;
    }

    public function setNatureableId(int $natureable_id)
    {
        $this->natureable_id = $natureable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="natureable_type",
     *     type="string",
     *     description="Natureable type property"
     * )
     */
    public function getNatureableType(): string
    {
        return $this->natureable_type;
    }

    public function setNatureableType(string $natureable_type)
    {
        $this->natureable_type = $natureable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="acft",
     *     type="string",
     *     description="Acft property"
     * )
     */
    public function getAcft(): string
    {
        return $this->acft;
    }

    public function setAcft(string $acft)
    {
        $this->acft = $acft;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="acftable_id",
     *     type="integer",
     *     format="int32",
     *     description="Acftable id property"
     * )
     */
    public function getAcftableId(): int
    {
        return $this->acftable_id;
    }

    public function setAcftableId(int $acftable_id)
    {
        $this->acftable_id = $acftable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="acftable_type",
     *     type="string",
     *     description="Acftable type property"
     * )
     */
    public function getAcftableType(): string
    {
        return $this->acftable_type;
    }

    public function setAcftableType(string $acftable_type)
    {
        $this->acftable_type = $acftable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="register",
     *     type="string",
     *     description="Register property"
     * )
     */
    public function getRegister(): string
    {
        return $this->register;
    }

    public function setRegister(string $register)
    {
        $this->register = $register;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="registerable_id",
     *     type="integer",
     *     format="int32",
     *     description="Registerable id property"
     * )
     */
    public function getRegisterableId(): int
    {
        return $this->registerable_id;
    }

    public function setRegisterableId(int $registerable_id)
    {
        $this->registerable_id = $registerable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="registerable_type",
     *     type="string",
     *     description="Registerable type property"
     * )
     */
    public function getRegisterableType(): string
    {
        return $this->registerable_type;
    }

    public function setRegisterableType(string $registerable_type)
    {
        $this->registerable_type = $registerable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="stand",
     *     type="string",
     *     description="Stand property"
     * )
     */
    public function getStand(): string
    {
        return $this->stand;
    }

    public function setStand(string $stand)
    {
        $this->stand = $stand;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="standable_id",
     *     type="integer",
     *     format="int32",
     *     description="Standable id property"
     * )
     */
    public function getStandableId(): int
    {
        return $this->standable_id;
    }

    public function setStandableId(int $standable_id)
    {
        $this->standable_id = $standable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="standable_type",
     *     type="string",
     *     description="Standable type property"
     * )
     */
    public function getStandableType(): string
    {
        return $this->standable_type;
    }

    public function setStandableType(string $standable_type)
    {
        $this->standable_type = $standable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gate_name",
     *     type="string",
     *     description="Gate name property"
     * )
     */
    public function getGateName(): string
    {
        return $this->gate_name;
    }

    public function setGateName(string $gate_name)
    {
        $this->gate_name = $gate_name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gate_nameable_id",
     *     type="integer",
     *     format="int32",
     *     description="Gate nameable id property"
     * )
     */
    public function getGateNameableId(): int
    {
        return $this->gate_nameable_id;
    }

    public function setGateNameableId(int $gate_nameable_id)
    {
        $this->gate_nameable_id = $gate_nameable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gate_nameable_type",
     *     type="string",
     *     description="Gate nameable type property"
     * )
     */
    public function getGateNameableType(): string
    {
        return $this->gate_nameable_type;
    }

    public function setGateNameableType(string $gate_nameable_type)
    {
        $this->gate_nameable_type = $gate_nameable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gate_open",
     *     type="string",
     *     format="date-time",
     *     description="Gate open property",
     *     example="YYYY-MM-DD HH:MM:SS"
     * )
     */
    public function getGateOpen(): DateTime
    {
        return $this->gate_open;
    }

    public function setGateOpen(DateTime $gate_open)
    {
        $this->gate_open = $gate_open->format(Config::get('datetime.format.database_datetime'));
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gate_openable_id",
     *     type="integer",
     *     format="int32",
     *     description="Gate openable id property"
     * )
     */
    public function getGateOpenableId(): int
    {
        return $this->gate_openable_id;
    }

    public function setGateOpenableId(int $gate_openable_id)
    {
        $this->gate_openable_id = $gate_openable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gate_openable_type",
     *     type="string",
     *     description="Gate openable type property"
     * )
     */
    public function getGateOpenableType(): string
    {
        return $this->gate_openable_type;
    }

    public function setGateOpenableType(string $gate_openable_type)
    {
        $this->gate_openable_type = $gate_openable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="runway_actual",
     *     type="string",
     *     description="Runway actual property"
     * )
     */
    public function getRunwayActual(): string
    {
        return $this->runway_actual;
    }

    public function setRunwayActual(string $runway_actual)
    {
        $this->runway_actual = $runway_actual;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="runway_actualable_id",
     *     type="integer",
     *     format="int32",
     *     description="Runway actualable id property"
     * )
     */
    public function getRunwayActualableId(): int
    {
        return $this->runway_actualable_id;
    }

    public function setRunwayActualableId(int $runway_actualable_id)
    {
        $this->runway_actualable_id = $runway_actualable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="runway_actualable_type",
     *     type="string",
     *     description="Runway actualable type property"
     * )
     */
    public function getRunwayActualableType(): string
    {
        return $this->runway_actualable_type;
    }

    public function setRunwayActualableType(string $runway_actualable_type)
    {
        $this->runway_actualable_type = $runway_actualable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="runway_estimated",
     *     type="string",
     *     description="Runway estimated property"
     * )
     */
    public function getRunwayEstimated(): string
    {
        return $this->runway_estimated;
    }

    public function setRunwayEstimated(string $runway_estimated)
    {
        $this->runway_estimated = $runway_estimated;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="runway_estimatedable_id",
     *     type="integer",
     *     format="int32",
     *     description="Runway estimatedable id property"
     * )
     */
    public function getRunwayEstimatedableId(): int
    {
        return $this->runway_estimatedable_id;
    }

    public function setRunwayEstimatedableId(int $runway_estimatedable_id)
    {
        $this->runway_estimatedable_id = $runway_estimatedable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="runway_estimatedable_type",
     *     type="string",
     *     description="Runway estimatedable type property"
     * )
     */
    public function getRunwayEstimatedableType(): string
    {
        return $this->runway_estimatedable_type;
    }

    public function setRunwayEstimatedableType(string $runway_estimatedable_type)
    {
        $this->runway_estimatedable_type = $runway_estimatedable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="transit",
     *     type="string",
     *     description="Transit property"
     * )
     */
    public function getTransit(): string
    {
        return $this->transit;
    }

    public function setTransit(string $transit)
    {
        $this->transit = $transit;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="transitable_id",
     *     type="integer",
     *     format="int32",
     *     description="Transitable id property"
     * )
     */
    public function getTransitableId(): int
    {
        return $this->transitable_id;
    }

    public function setTransitableId(int $transitable_id)
    {
        $this->transitable_id = $transitable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="transitable_type",
     *     type="string",
     *     description="Transitable type property"
     * )
     */
    public function getTransitableType(): string
    {
        return $this->transitable_type;
    }

    public function setTransitableType(string $transitable_type)
    {
        $this->transitable_type = $transitable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="destination",
     *     type="string",
     *     description="Destination property"
     * )
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    public function setDestination(string $destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="destinationable_id",
     *     type="integer",
     *     format="int32",
     *     description="Destinationable id property"
     * )
     */
    public function getDestinationableId(): int
    {
        return $this->destinationable_id;
    }

    public function setDestinationableId(int $destinationable_id)
    {
        $this->destinationable_id = $destinationable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="destinationable_type",
     *     type="string",
     *     description="Destinationable type property"
     * )
     */
    public function getDestinationableType(): string
    {
        return $this->destinationable_type;
    }

    public function setDestinationableType(string $destinationable_type)
    {
        $this->destinationable_type = $destinationable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     description="Status property"
     * )
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="code_share",
     *     type="string",
     *     description="Code share property"
     * )
     */
    public function getCodeShare(): string
    {
        return $this->code_share;
    }

    public function setCodeShare(string $code_share)
    {
        $this->code_share = $code_share;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="data_origin",
     *     type="string",
     *     description="Data origin property"
     * )
     */
    public function getDataOrigin(): string
    {
        return $this->data_origin;
    }

    public function setDataOrigin(string $data_origin)
    {
        $this->data_origin = $data_origin;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="data_originable_id",
     *     type="integer",
     *     format="int32",
     *     description="Data originable id property"
     * )
     */
    public function getDataOriginableId(): int
    {
        return $this->data_originable_id;
    }

    public function setDataOriginableId(int $data_originable_id)
    {
        $this->data_originable_id = $data_originable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="data_originable_type",
     *     type="string",
     *     description="Data originable type property"
     * )
     */
    public function getDataOriginableType(): string
    {
        return $this->data_originable_type;
    }

    public function setDataOriginableType(string $data_originable_type)
    {
        $this->data_originable_type = $data_originable_type;
        return $this;
    }


    public function departureMeta()
    {
        return $this->hasOne(DepartureMetaEloquent::class, 'departure_id');
    }

    public function flightInformations()
    {
        return $this->hasMany(FlightInformationEloquent::class, 'departure_id');
    }

    public function acgts()
    {
        return $this->hasMany(AcgtEloquent::class, 'departure_id');
    }

    public function aczts()
    {
        return $this->hasMany(AcztEloquent::class, 'departure_id');
    }

    public function adits()
    {
        return $this->hasMany(AditEloquent::class, 'departure_id');
    }

    public function aegts()
    {
        return $this->hasMany(AegtEloquent::class, 'departure_id');
    }

    public function aezts()
    {
        return $this->hasMany(AeztEloquent::class, 'departure_id');
    }

    public function aghts()
    {
        return $this->hasMany(AghtEloquent::class, 'departure_id');
    }

    public function aobts()
    {
        return $this->hasMany(AobtEloquent::class, 'departure_id');
    }

    public function ardts()
    {
        return $this->hasMany(ArdtEloquent::class, 'departure_id');
    }

    public function arzts()
    {
        return $this->hasMany(ArztEloquent::class, 'departure_id');
    }

    public function asbts()
    {
        return $this->hasMany(AsbtEloquent::class, 'departure_id');
    }

    public function asrts()
    {
        return $this->hasMany(AsrtEloquent::class, 'departure_id');
    }

    public function atets()
    {
        return $this->hasMany(AtetEloquent::class, 'departure_id');
    }

    public function atots()
    {
        return $this->hasMany(AtotEloquent::class, 'departure_id');
    }

    public function atsts()
    {
        return $this->hasMany(AtstEloquent::class, 'departure_id');
    }

    public function attts()
    {
        return $this->hasMany(AtttEloquent::class, 'departure_id');
    }

    public function axots()
    {
        return $this->hasMany(AxotEloquent::class, 'departure_id');
    }

    public function azats()
    {
        return $this->hasMany(AzatEloquent::class, 'departure_id');
    }

    public function ctots()
    {
        return $this->hasMany(CtotEloquent::class, 'departure_id');
    }

    public function eczts()
    {
        return $this->hasMany(EcztEloquent::class, 'departure_id');
    }

    public function edits()
    {
        return $this->hasMany(EditEloquent::class, 'departure_id');
    }

    public function eezts()
    {
        return $this->hasMany(EeztEloquent::class, 'departure_id');
    }

    public function eobts()
    {
        return $this->hasMany(EobtEloquent::class, 'departure_id');
    }

    public function erzts()
    {
        return $this->hasMany(EeztEloquent::class, 'departure_id');
    }

    public function etots()
    {
        return $this->hasMany(EtotEloquent::class, 'departure_id');
    }

    public function exots()
    {
        return $this->hasMany(ExotEloquent::class, 'departure_id');
    }

    public function sobts()
    {
        return $this->hasMany(SobtEloquent::class, 'departure_id');
    }

    public function stets()
    {
        return $this->hasMany(StetEloquent::class, 'departure_id');
    }

    public function ststs()
    {
        return $this->hasMany(StstEloquent::class, 'departure_id');
    }

    public function tobts()
    {
        return $this->hasMany(TobtEloquent::class, 'departure_id');
    }

    public function tsats()
    {
        return $this->hasMany(TsatEloquent::class, 'departure_id');
    }

    public function ttots()
    {
        return $this->hasMany(TtotEloquent::class, 'departure_id');
    }

    public function airport()
    {
        return $this->belongsTo(AirportEloquent::class, 'airport_id');
    }

    public function flightNumberable()
    {
        return $this->morphTo();
    }

    public function natureable()
    {
        return $this->morphTo();
    }

    public function acftable()
    {
        return $this->morphTo();
    }

    public function registerable()
    {
        return $this->morphTo();
    }

    public function standable()
    {
        return $this->morphTo();
    }

    public function gateNameable()
    {
        return $this->morphTo();
    }

    public function gateOpenable()
    {
        return $this->morphTo();
    }

    public function runwayActualable()
    {
        return $this->morphTo();
    }

    public function runwayEstimatedable()
    {
        return $this->morphTo();
    }

    public function transitable()
    {
        return $this->morphTo();
    }

    public function destinationable()
    {
        return $this->morphTo();
    }

    public function dataOriginable()
    {
        return $this->morphTo();
    }
}

Relation::morphMap([
    IRoleEloquent::MORPH_NAME => RoleEloquent::class,
    IVendorEloquent::MORPH_NAME => VendorEloquent::class
]);

/**
 * @OA\Schema(
 *     schema="DepartureResponse",
 *     title="Departure Response",
 *     description="Departure response schema",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/DepartureEloquent"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="sobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Sobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="eobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Eobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="tobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Eobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="aegt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Aegt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="ardt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Ardt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="tsat",
 *                 type="string",
 *                 format="date-time",
 *                 description="Tsat property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="aobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Aobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="acgt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Acgt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="ttot",
 *                 type="string",
 *                 format="date-time",
 *                 description="Ttot property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="atot",
 *                 type="string",
 *                 format="date-time",
 *                 description="Atot property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="departure_meta",
 *                 type="object",
 *                 description="Departure meta property",
 *                 ref="#/components/schemas/DepartureMetaEloquent"
 *             )
 *         )
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="DepartureHistoryResponse",
 *     title="Departure History Response",
 *     description="Departure history response schema",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/DepartureEloquent"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="sobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Sobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="eobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Eobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="tobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Eobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="aegt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Aegt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="ardt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Ardt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="tsat",
 *                 type="string",
 *                 format="date-time",
 *                 description="Tsat property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="aobt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Aobt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="acgt",
 *                 type="string",
 *                 format="date-time",
 *                 description="Acgt property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="ttot",
 *                 type="string",
 *                 format="date-time",
 *                 description="Ttot property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             ),
 *             @OA\Property(
 *                 property="atot",
 *                 type="string",
 *                 format="date-time",
 *                 description="Atot property",
 *                 example="YYYY-MM-DD HH:MM:SS"
 *             )
 *         )
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="DepartureTobtUpdatedResponse",
 *     title="Departure Tobt Updated Response",
 *     description="Departure tobt updated response schema",
 *     @OA\Property(
 *         property="departure_tobts_updated",
 *         type="array",
 *         @OA\Items(),
 *         example={}
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_super_admin_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_admin_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_military_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_airport_operator_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_ground_services_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_airline_operator_center_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_dispatcher_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_gh_coordinator_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_supervisor_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_clearance_delivery_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_ground_controller_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_flow_control_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_approach_control_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="depature_has_updated_by_area_control_count",
 *         type="integer",
 *         format="int64",
 *         example=0
 *     )
 * )
 */


