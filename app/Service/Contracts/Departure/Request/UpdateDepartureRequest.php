<?php


namespace App\Service\Contracts\Departure\Request;


use App\Core\Service\Request\IdentityAuditableRequest;
use DateTime;

/**
 * @OA\Schema(
 *     schema="DepartureIdRequest",
 *     title="Departure Id Request",
 *     description="Departure id request schema",
 *     required={"id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Departure id property"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="DepartureAodbIdRequest",
 *     title="Departure aodb id Request",
 *     description="Departure aodb id request schema",
 *     required={"aodb_id"},
 *     @OA\Property(
 *         property="aodb_id",
 *         type="integer",
 *         format="int64",
 *         description="Departure aodb id property"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateDepartureRequest",
 *     title="Update Departure Request",
 *     description="Update departure request schema",
 *     required={"airport_id"}
 * )
 */
class UpdateDepartureRequest extends IdentityAuditableRequest
{
    public int $aodb_id;

    /**
     * @OA\Property(
     *     property="airport_id",
     *     type="integer",
     *     format="int64",
     *     description="Airport id property"
     * )
     */
    public int $airport_id;

    /**
     * @OA\Property(
     *     property="flight_number",
     *     type="string",
     *     description="Flight number property"
     * )
     */
    public ?string $flight_number;

    /**
     * @OA\Property(
     *     property="flight_numberable_id",
     *     type="integer",
     *     format="int32",
     *     description="Flight numberable id property"
     * )
     */
    public ?int $flight_numberable_id;

    /**
     * @OA\Property(
     *     property="flight_numberable_type",
     *     type="string",
     *     description="Flight numberable type property"
     * )
     */
    public ?string $flight_numberable_type;

    /**
     * @OA\Property(
     *     property="call_sign",
     *     type="string",
     *     description="Call sign property"
     * )
     */
    public ?string $call_sign;

    /**
     * @OA\Property(
     *     property="nature",
     *     type="string",
     *     description="Nature property"
     * )
     */
    public ?string $nature;

    /**
     * @OA\Property(
     *     property="natureable_id",
     *     type="integer",
     *     format="int32",
     *     description="Natureable id property"
     * )
     */
    public ?int $natureable_id;

    /**
     * @OA\Property(
     *     property="natureable_type",
     *     type="string",
     *     description="Natureable type property"
     * )
     */
    public ?string $natureable_type;

    /**
     * @OA\Property(
     *     property="acft",
     *     type="string",
     *     description="Acft property"
     * )
     */
    public ?string $acft;

    /**
     * @OA\Property(
     *     property="acftable_id",
     *     type="integer",
     *     format="int32",
     *     description="Acftable id property"
     * )
     */
    public ?int $acftable_id;

    /**
     * @OA\Property(
     *     property="acftable_type",
     *     type="string",
     *     description="Acftable type property"
     * )
     */
    public ?string $acftable_type;

    /**
     * @OA\Property(
     *     property="register",
     *     type="string",
     *     description="Register property"
     * )
     */
    public ?string $register;

    /**
     * @OA\Property(
     *     property="registerable_id",
     *     type="integer",
     *     format="int32",
     *     description="Registerable id property"
     * )
     */
    public ?int $registerable_id;

    /**
     * @OA\Property(
     *     property="registerable_type",
     *     type="string",
     *     description="Registerable type property"
     * )
     */
    public ?string $registerable_type;

    /**
     * @OA\Property(
     *     property="stand",
     *     type="string",
     *     description="Stand property"
     * )
     */
    public ?string $stand;

    /**
     * @OA\Property(
     *     property="standable_id",
     *     type="integer",
     *     format="int32",
     *     description="Standable id property"
     * )
     */
    public ?int $standable_id;

    /**
     * @OA\Property(
     *     property="standable_type",
     *     type="string",
     *     description="Standable type property"
     * )
     */
    public ?string $standable_type;

    /**
     * @OA\Property(
     *     property="gate_name",
     *     type="string",
     *     description="Gate name property"
     * )
     */
    public ?string $gate_name;

    /**
     * @OA\Property(
     *     property="gate_nameable_id",
     *     type="integer",
     *     format="int32",
     *     description="Gate nameable id property"
     * )
     */
    public ?int $gate_nameable_id;

    /**
     * @OA\Property(
     *     property="gate_nameable_type",
     *     type="string",
     *     description="Gate nameable type property"
     * )
     */
    public ?string $gate_nameable_type;

    /**
     * @OA\Property(
     *     property="gate_open",
     *     type="string",
     *     description="Gate open property"
     * )
     */
    public ?DateTime $gate_open;

    /**
     * @OA\Property(
     *     property="gate_openable_id",
     *     type="integer",
     *     format="int32",
     *     description="Gate openable id property"
     * )
     */
    public ?int $gate_openable_id;

    /**
     * @OA\Property(
     *     property="gate_openable_type",
     *     type="string",
     *     description="Gate openable type property"
     * )
     */
    public ?string $gate_openable_type;

    /**
     * @OA\Property(
     *     property="runway_actual",
     *     type="string",
     *     description="Runway actual property"
     * )
     */
    public ?string $runway_actual;

    /**
     * @OA\Property(
     *     property="runway_actualable_id",
     *     type="integer",
     *     format="int32",
     *     description="Runway actualable id property"
     * )
     */
    public ?int $runway_actualable_id;

    /**
     * @OA\Property(
     *     property="runway_actualable_type",
     *     type="string",
     *     description="Runway actualable type property"
     * )
     */
    public ?string $runway_actualable_type;

    /**
     * @OA\Property(
     *     property="runway_estimated",
     *     type="string",
     *     description="Runway estimated property"
     * )
     */
    public ?string $runway_estimated;

    /**
     * @OA\Property(
     *     property="runway_estimatedable_id",
     *     type="integer",
     *     format="int32",
     *     description="Runway estimatedable id property"
     * )
     */
    public ?int $runway_estimatedable_id;

    /**
     * @OA\Property(
     *     property="runway_estimatedable_type",
     *     type="string",
     *     description="Runway estimatedable type property"
     * )
     */
    public ?string $runway_estimatedable_type;

    /**
     * @OA\Property(
     *     property="transit",
     *     type="string",
     *     description="Transit property"
     * )
     */
    public ?string $transit;

    /**
     * @OA\Property(
     *     property="transitable_id",
     *     type="integer",
     *     format="int32",
     *     description="Transitable id property"
     * )
     */
    public ?int $transitable_id;

    /**
     * @OA\Property(
     *     property="transitable_type",
     *     type="string",
     *     description="Transitable type property"
     * )
     */
    public ?string $transitable_type;

    /**
     * @OA\Property(
     *     property="destination",
     *     type="string",
     *     description="Destination property"
     * )
     */
    public ?string $destination;

    /**
     * @OA\Property(
     *     property="destinationable_id",
     *     type="integer",
     *     format="int32",
     *     description="Destinationable id property"
     * )
     */
    public ?int $destinationable_id;

    /**
     * @OA\Property(
     *     property="destinationable_type",
     *     type="string",
     *     description="Destinationable type property"
     * )
     */
    public ?string $destinationable_type;

    /**
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     description="Status property"
     * )
     */
    public ?string $status;

    /**
     * @OA\Property(
     *     property="code_share",
     *     type="string",
     *     description="Code share property"
     * )
     */
    public ?string $code_share;

    /**
     * @OA\Property(
     *     property="data_origin",
     *     type="string",
     *     description="Data origin property"
     * )
     */
    public ?string $data_origin;

    /**
     * @OA\Property(
     *     property="data_originable_id",
     *     type="integer",
     *     format="int32",
     *     description="Data originable id property"
     * )
     */
    public ?int $data_originable_id;

    /**
     * @OA\Property(
     *     property="data_originable_type",
     *     type="string",
     *     description="Data originable type property"
     * )
     */
    public ?string $data_originable_type;

    /**
     * @OA\Property(
     *     property="acgts",
     *     description="Acgt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AcgtCreateRequest")
     * )
     */
    public ?array $acgts = null;

    /**
     * @OA\Property(
     *     property="aczts",
     *     description="Aczt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AcztCreateRequest")
     * )
     */
    public ?array $aczts = null;

    /**
     * @OA\Property(
     *     property="adits",
     *     description="Adit property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AditCreateRequest")
     * )
     */
    public ?array $adits = null;

    /**
     * @OA\Property(
     *     property="aegts",
     *     description="Aegt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AegtCreateRequest")
     * )
     */
    public ?array $aegts = null;

    /**
     * @OA\Property(
     *     property="aezts",
     *     description="Aezt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AeztCreateRequest")
     * )
     */
    public ?array $aezts = null;

    /**
     * @OA\Property(
     *     property="aghts",
     *     description="Aght property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AghtCreateRequest")
     * )
     */
    public ?array $aghts = null;

    /**
     * @OA\Property(
     *     property="aobts",
     *     description="Aobt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AobtCreateRequest")
     * )
     */
    public ?array $aobts = null;

    /**
     * @OA\Property(
     *     property="ardts",
     *     description="Ardt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/ArdtCreateRequest")
     * )
     */
    public ?array $ardts = null;

    /**
     * @OA\Property(
     *     property="arzts",
     *     description="Arzt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/ArztCreateRequest")
     * )
     */
    public ?array $arzts = null;

    /**
     * @OA\Property(
     *     property="azats",
     *     description="Azat property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AzatCreateRequest")
     * )
     */
    public ?array $azats = null;

    /**
     * @OA\Property(
     *     property="asbts",
     *     description="Asbt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AsbtCreateRequest")
     * )
     */
    public ?array $asbts = null;

    /**
     * @OA\Property(
     *     property="asrts",
     *     description="Asrt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AsrtCreateRequest")
     * )
     */
    public ?array $asrts = null;

    /**
     * @OA\Property(
     *     property="atets",
     *     description="Atet property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AtetCreateRequest")
     * )
     */
    public ?array $atets = null;

    /**
     * @OA\Property(
     *     property="atsts",
     *     description="Atst property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AtstCreateRequest")
     * )
     */
    public ?array $atsts = null;

    /**
     * @OA\Property(
     *     property="atots",
     *     description="Atot property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AtotCreateRequest")
     * )
     */
    public ?array $atots = null;

    /**
     * @OA\Property(
     *     property="attts",
     *     description="Attt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AtttCreateRequest")
     * )
     */
    public ?array $attts = null;

    /**
     * @OA\Property(
     *     property="axots",
     *     description="Axot property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AxotCreateRequest")
     * )
     */
    public ?array $axots = null;

    /**
     * @OA\Property(
     *     property="ctots",
     *     description="Ctot property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/CtotCreateRequest")
     * )
     */
    public ?array $ctots = null;

    /**
     * @OA\Property(
     *     property="eczts",
     *     description="Eczt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/EcztCreateRequest")
     * )
     */
    public ?array $eczts = null;

    /**
     * @OA\Property(
     *     property="edits",
     *     description="Edit property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/EditCreateRequest")
     * )
     */
    public ?array $edits = null;

    /**
     * @OA\Property(
     *     property="eezts",
     *     description="Eezt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/EeztCreateRequest")
     * )
     */
    public ?array $eezts = null;

    /**
     * @OA\Property(
     *     property="eobts",
     *     description="Eobt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/EobtCreateRequest")
     * )
     */
    public ?array $eobts = null;

    /**
     * @OA\Property(
     *     property="erzts",
     *     description="Erzt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/ErztCreateRequest")
     * )
     */
    public ?array $erzts = null;

    /**
     * @OA\Property(
     *     property="etots",
     *     description="Etot property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/EtotCreateRequest")
     * )
     */
    public ?array $etots = null;

    /**
     * @OA\Property(
     *     property="exots",
     *     description="Exot property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/ExotCreateRequest")
     * )
     */
    public ?array $exots = null;

    /**
     * @OA\Property(
     *     property="sobts",
     *     description="Sobt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/SobtCreateRequest")
     * )
     */
    public ?array $sobts = null;

    /**
     * @OA\Property(
     *     property="stets",
     *     description="Stet property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/StetCreateRequest")
     * )
     */
    public ?array $stets = null;

    /**
     * @OA\Property(
     *     property="ststs",
     *     description="Stst property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/StstCreateRequest")
     * )
     */
    public ?array $ststs = null;

    /**
     * @OA\Property(
     *     property="tobts",
     *     description="Tobt property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/TobtCreateRequest")
     * )
     */
    public ?array $tobts = null;

    /**
     * @OA\Property(
     *     property="tsats",
     *     description="Tsat property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/TsatCreateRequest")
     * )
     */
    public ?array $tsats = null;

    /**
     * @OA\Property(
     *     property="ttots",
     *     description="Ttot property",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/TtotCreateRequest")
     * )
     */
    public ?array $ttots = null;

    /**
     * @OA\Property(
     *     property="departure_meta",
     *     description="Departure meta property",
     *     type="object",
     *     ref="#/components/schemas/CreateDepartureMetaRequest"
     * )
     */
    public ?object $departure_meta = null;

    /**
     * @return int
     */
    public function getAodbId(): int
    {
        return $this->aodb_id;
    }

    /**
     * @param int $aodb_id
     */
    public function setAodbId(int $aodb_id): void
    {
        $this->aodb_id = $aodb_id;
    }

    /**
     * @return int
     */
    public function getAirportId(): int
    {
        return $this->airport_id;
    }

    /**
     * @param int $airport_id
     */
    public function setAirportId(int $airport_id): void
    {
        $this->airport_id = $airport_id;
    }

    /**
     * @return string|null
     */
    public function getFlightNumber(): ?string
    {
        return $this->flight_number;
    }

    /**
     * @param string|null $flight_number
     */
    public function setFlightNumber(?string $flight_number): void
    {
        $this->flight_number = $flight_number;
    }

    /**
     * @return int|null
     */
    public function getFlightNumberableId(): ?int
    {
        return $this->flight_numberable_id;
    }

    /**
     * @param int|null $flight_numberable_id
     */
    public function setFlightNumberableId(?int $flight_numberable_id): void
    {
        $this->flight_numberable_id = $flight_numberable_id;
    }

    /**
     * @return string|null
     */
    public function getFlightNumberableType(): ?string
    {
        return $this->flight_numberable_type;
    }

    /**
     * @param string|null $flight_numberable_type
     */
    public function setFlightNumberableType(?string $flight_numberable_type): void
    {
        $this->flight_numberable_type = $flight_numberable_type;
    }

    /**
     * @return string|null
     */
    public function getCallSign(): ?string
    {
        return $this->call_sign;
    }

    /**
     * @param string|null $call_sign
     */
    public function setCallSign(?string $call_sign): void
    {
        $this->call_sign = $call_sign;
    }

    /**
     * @return string|null
     */
    public function getNature(): ?string
    {
        return $this->nature;
    }

    /**
     * @param string|null $nature
     */
    public function setNature(?string $nature): void
    {
        $this->nature = $nature;
    }

    /**
     * @return int|null
     */
    public function getNatureableId(): ?int
    {
        return $this->natureable_id;
    }

    /**
     * @param int|null $natureable_id
     */
    public function setNatureableId(?int $natureable_id): void
    {
        $this->natureable_id = $natureable_id;
    }

    /**
     * @return string|null
     */
    public function getNatureableType(): ?string
    {
        return $this->natureable_type;
    }

    /**
     * @param string|null $natureable_type
     */
    public function setNatureableType(?string $natureable_type): void
    {
        $this->natureable_type = $natureable_type;
    }

    /**
     * @return string|null
     */
    public function getAcft(): ?string
    {
        return $this->acft;
    }

    /**
     * @param string|null $acft
     */
    public function setAcft(?string $acft): void
    {
        $this->acft = $acft;
    }

    /**
     * @return int|null
     */
    public function getAcftableId(): ?int
    {
        return $this->acftable_id;
    }

    /**
     * @param int|null $acftable_id
     */
    public function setAcftableId(?int $acftable_id): void
    {
        $this->acftable_id = $acftable_id;
    }

    /**
     * @return string|null
     */
    public function getAcftableType(): ?string
    {
        return $this->acftable_type;
    }

    /**
     * @param string|null $acftable_type
     */
    public function setAcftableType(?string $acftable_type): void
    {
        $this->acftable_type = $acftable_type;
    }

    /**
     * @return string|null
     */
    public function getRegister(): ?string
    {
        return $this->register;
    }

    /**
     * @param string|null $register
     */
    public function setRegister(?string $register): void
    {
        $this->register = $register;
    }

    /**
     * @return int|null
     */
    public function getRegisterableId(): ?int
    {
        return $this->registerable_id;
    }

    /**
     * @param int|null $registerable_id
     */
    public function setRegisterableId(?int $registerable_id): void
    {
        $this->registerable_id = $registerable_id;
    }

    /**
     * @return string|null
     */
    public function getRegisterableType(): ?string
    {
        return $this->registerable_type;
    }

    /**
     * @param string|null $registerable_type
     */
    public function setRegisterableType(?string $registerable_type): void
    {
        $this->registerable_type = $registerable_type;
    }

    /**
     * @return string|null
     */
    public function getStand(): ?string
    {
        return $this->stand;
    }

    /**
     * @param string|null $stand
     */
    public function setStand(?string $stand): void
    {
        $this->stand = $stand;
    }

    /**
     * @return int|null
     */
    public function getStandableId(): ?int
    {
        return $this->standable_id;
    }

    /**
     * @param int|null $standable_id
     */
    public function setStandableId(?int $standable_id): void
    {
        $this->standable_id = $standable_id;
    }

    /**
     * @return string|null
     */
    public function getStandableType(): ?string
    {
        return $this->standable_type;
    }

    /**
     * @param string|null $standable_type
     */
    public function setStandableType(?string $standable_type): void
    {
        $this->standable_type = $standable_type;
    }

    /**
     * @return string|null
     */
    public function getGateName(): ?string
    {
        return $this->gate_name;
    }

    /**
     * @param string|null $gate_name
     */
    public function setGateName(?string $gate_name): void
    {
        $this->gate_name = $gate_name;
    }

    /**
     * @return int|null
     */
    public function getGateNameableId(): ?int
    {
        return $this->gate_nameable_id;
    }

    /**
     * @param int|null $gate_nameable_id
     */
    public function setGateNameableId(?int $gate_nameable_id): void
    {
        $this->gate_nameable_id = $gate_nameable_id;
    }

    /**
     * @return string|null
     */
    public function getGateNameableType(): ?string
    {
        return $this->gate_nameable_type;
    }

    /**
     * @param string|null $gate_nameable_type
     */
    public function setGateNameableType(?string $gate_nameable_type): void
    {
        $this->gate_nameable_type = $gate_nameable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getGateOpen(): ?DateTime
    {
        return $this->gate_open;
    }

    /**
     * @param DateTime|null $gate_open
     */
    public function setGateOpen(?DateTime $gate_open): void
    {
        $this->gate_open = $gate_open;
    }

    /**
     * @return int|null
     */
    public function getGateOpenableId(): ?int
    {
        return $this->gate_openable_id;
    }

    /**
     * @param int|null $gate_openable_id
     */
    public function setGateOpenableId(?int $gate_openable_id): void
    {
        $this->gate_openable_id = $gate_openable_id;
    }

    /**
     * @return string|null
     */
    public function getGateOpenableType(): ?string
    {
        return $this->gate_openable_type;
    }

    /**
     * @param string|null $gate_openable_type
     */
    public function setGateOpenableType(?string $gate_openable_type): void
    {
        $this->gate_openable_type = $gate_openable_type;
    }

    /**
     * @return string|null
     */
    public function getRunwayActual(): ?string
    {
        return $this->runway_actual;
    }

    /**
     * @param string|null $runway_actual
     */
    public function setRunwayActual(?string $runway_actual): void
    {
        $this->runway_actual = $runway_actual;
    }

    /**
     * @return int|null
     */
    public function getRunwayActualableId(): ?int
    {
        return $this->runway_actualable_id;
    }

    /**
     * @param int|null $runway_actualable_id
     */
    public function setRunwayActualableId(?int $runway_actualable_id): void
    {
        $this->runway_actualable_id = $runway_actualable_id;
    }

    /**
     * @return string|null
     */
    public function getRunwayActualableType(): ?string
    {
        return $this->runway_actualable_type;
    }

    /**
     * @param string|null $runway_actualable_type
     */
    public function setRunwayActualableType(?string $runway_actualable_type): void
    {
        $this->runway_actualable_type = $runway_actualable_type;
    }

    /**
     * @return string|null
     */
    public function getRunwayEstimated(): ?string
    {
        return $this->runway_estimated;
    }

    /**
     * @param string|null $runway_estimated
     */
    public function setRunwayEstimated(?string $runway_estimated): void
    {
        $this->runway_estimated = $runway_estimated;
    }

    /**
     * @return int|null
     */
    public function getRunwayEstimatedableId(): ?int
    {
        return $this->runway_estimatedable_id;
    }

    /**
     * @param int|null $runway_estimatedable_id
     */
    public function setRunwayEstimatedableId(?int $runway_estimatedable_id): void
    {
        $this->runway_estimatedable_id = $runway_estimatedable_id;
    }

    /**
     * @return string|null
     */
    public function getRunwayEstimatedableType(): ?string
    {
        return $this->runway_estimatedable_type;
    }

    /**
     * @param string|null $runway_estimatedable_type
     */
    public function setRunwayEstimatedableType(?string $runway_estimatedable_type): void
    {
        $this->runway_estimatedable_type = $runway_estimatedable_type;
    }

    /**
     * @return string|null
     */
    public function getTransit(): ?string
    {
        return $this->transit;
    }

    /**
     * @param string|null $transit
     */
    public function setTransit(?string $transit): void
    {
        $this->transit = $transit;
    }

    /**
     * @return int|null
     */
    public function getTransitableId(): ?int
    {
        return $this->transitable_id;
    }

    /**
     * @param int|null $transitable_id
     */
    public function setTransitableId(?int $transitable_id): void
    {
        $this->transitable_id = $transitable_id;
    }

    /**
     * @return string|null
     */
    public function getTransitableType(): ?string
    {
        return $this->transitable_type;
    }

    /**
     * @param string|null $transitable_type
     */
    public function setTransitableType(?string $transitable_type): void
    {
        $this->transitable_type = $transitable_type;
    }

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @param string|null $destination
     */
    public function setDestination(?string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return int|null
     */
    public function getDestinationableId(): ?int
    {
        return $this->destinationable_id;
    }

    /**
     * @param int|null $destinationable_id
     */
    public function setDestinationableId(?int $destinationable_id): void
    {
        $this->destinationable_id = $destinationable_id;
    }

    /**
     * @return string|null
     */
    public function getDestinationableType(): ?string
    {
        return $this->destinationable_type;
    }

    /**
     * @param string|null $destinationable_type
     */
    public function setDestinationableType(?string $destinationable_type): void
    {
        $this->destinationable_type = $destinationable_type;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getCodeShare(): ?string
    {
        return $this->code_share;
    }

    /**
     * @param string|null $code_share
     */
    public function setCodeShare(?string $code_share): void
    {
        $this->code_share = $code_share;
    }

    /**
     * @return string|null
     */
    public function getDataOrigin(): ?string
    {
        return $this->data_origin;
    }

    /**
     * @param string|null $data_origin
     */
    public function setDataOrigin(?string $data_origin): void
    {
        $this->data_origin = $data_origin;
    }

    /**
     * @return int|null
     */
    public function getDataOriginableId(): ?int
    {
        return $this->data_originable_id;
    }

    /**
     * @param int|null $data_originable_id
     */
    public function setDataOriginableId(?int $data_originable_id): void
    {
        $this->data_originable_id = $data_originable_id;
    }

    /**
     * @return string|null
     */
    public function getDataOriginableType(): ?string
    {
        return $this->data_originable_type;
    }

    /**
     * @param string|null $data_originable_type
     */
    public function setDataOriginableType(?string $data_originable_type): void
    {
        $this->data_originable_type = $data_originable_type;
    }

    /**
     * @return array|null
     */
    public function getAcgts(): ?array
    {
        return $this->acgts;
    }

    /**
     * @param array|null $acgts
     */
    public function setAcgts(?array $acgts): void
    {
        $this->acgts = $acgts;
    }

    /**
     * @return array|null
     */
    public function getAczts(): ?array
    {
        return $this->aczts;
    }

    /**
     * @param array|null $aczts
     */
    public function setAczts(?array $aczts): void
    {
        $this->aczts = $aczts;
    }

    /**
     * @return array|null
     */
    public function getAdits(): ?array
    {
        return $this->adits;
    }

    /**
     * @param array|null $adits
     */
    public function setAdits(?array $adits): void
    {
        $this->adits = $adits;
    }

    /**
     * @return array|null
     */
    public function getAegts(): ?array
    {
        return $this->aegts;
    }

    /**
     * @param array|null $aegts
     */
    public function setAegts(?array $aegts): void
    {
        $this->aegts = $aegts;
    }

    /**
     * @return array|null
     */
    public function getAezts(): ?array
    {
        return $this->aezts;
    }

    /**
     * @param array|null $aezts
     */
    public function setAezts(?array $aezts): void
    {
        $this->aezts = $aezts;
    }

    /**
     * @return array|null
     */
    public function getAghts(): ?array
    {
        return $this->aghts;
    }

    /**
     * @param array|null $aghts
     */
    public function setAghts(?array $aghts): void
    {
        $this->aghts = $aghts;
    }

    /**
     * @return array|null
     */
    public function getAobts(): ?array
    {
        return $this->aobts;
    }

    /**
     * @param array|null $aobts
     */
    public function setAobts(?array $aobts): void
    {
        $this->aobts = $aobts;
    }

    /**
     * @return array|null
     */
    public function getArdts(): ?array
    {
        return $this->ardts;
    }

    /**
     * @param array|null $ardts
     */
    public function setArdts(?array $ardts): void
    {
        $this->ardts = $ardts;
    }

    /**
     * @return array|null
     */
    public function getArzts(): ?array
    {
        return $this->arzts;
    }

    /**
     * @param array|null $arzts
     */
    public function setArzts(?array $arzts): void
    {
        $this->arzts = $arzts;
    }

    /**
     * @return array|null
     */
    public function getAzats(): ?array
    {
        return $this->azats;
    }

    /**
     * @param array|null $azats
     */
    public function setAzats(?array $azats): void
    {
        $this->azats = $azats;
    }

    /**
     * @return array|null
     */
    public function getAsbts(): ?array
    {
        return $this->asbts;
    }

    /**
     * @param array|null $asbts
     */
    public function setAsbts(?array $asbts): void
    {
        $this->asbts = $asbts;
    }

    /**
     * @return array|null
     */
    public function getAsrts(): ?array
    {
        return $this->asrts;
    }

    /**
     * @param array|null $asrts
     */
    public function setAsrts(?array $asrts): void
    {
        $this->asrts = $asrts;
    }

    /**
     * @return array|null
     */
    public function getAtets(): ?array
    {
        return $this->atets;
    }

    /**
     * @param array|null $atets
     */
    public function setAtets(?array $atets): void
    {
        $this->atets = $atets;
    }

    /**
     * @return array|null
     */
    public function getAtsts(): ?array
    {
        return $this->atsts;
    }

    /**
     * @param array|null $atsts
     */
    public function setAtsts(?array $atsts): void
    {
        $this->atsts = $atsts;
    }

    /**
     * @return array|null
     */
    public function getAtots(): ?array
    {
        return $this->atots;
    }

    /**
     * @param array|null $atots
     */
    public function setAtots(?array $atots): void
    {
        $this->atots = $atots;
    }

    /**
     * @return array|null
     */
    public function getAttts(): ?array
    {
        return $this->attts;
    }

    /**
     * @param array|null $attts
     */
    public function setAttts(?array $attts): void
    {
        $this->attts = $attts;
    }

    /**
     * @return array|null
     */
    public function getAxots(): ?array
    {
        return $this->axots;
    }

    /**
     * @param array|null $axots
     */
    public function setAxots(?array $axots): void
    {
        $this->axots = $axots;
    }

    /**
     * @return array|null
     */
    public function getCtots(): ?array
    {
        return $this->ctots;
    }

    /**
     * @param array|null $ctots
     */
    public function setCtots(?array $ctots): void
    {
        $this->ctots = $ctots;
    }

    /**
     * @return array|null
     */
    public function getEczts(): ?array
    {
        return $this->eczts;
    }

    /**
     * @param array|null $eczts
     */
    public function setEczts(?array $eczts): void
    {
        $this->eczts = $eczts;
    }

    /**
     * @return array|null
     */
    public function getEdits(): ?array
    {
        return $this->edits;
    }

    /**
     * @param array|null $edits
     */
    public function setEdits(?array $edits): void
    {
        $this->edits = $edits;
    }

    /**
     * @return array|null
     */
    public function getEezts(): ?array
    {
        return $this->eezts;
    }

    /**
     * @param array|null $eezts
     */
    public function setEezts(?array $eezts): void
    {
        $this->eezts = $eezts;
    }

    /**
     * @return array|null
     */
    public function getEobts(): ?array
    {
        return $this->eobts;
    }

    /**
     * @param array|null $eobts
     */
    public function setEobts(?array $eobts): void
    {
        $this->eobts = $eobts;
    }

    /**
     * @return array|null
     */
    public function getErzts(): ?array
    {
        return $this->erzts;
    }

    /**
     * @param array|null $erzts
     */
    public function setErzts(?array $erzts): void
    {
        $this->erzts = $erzts;
    }

    /**
     * @return array|null
     */
    public function getEtots(): ?array
    {
        return $this->etots;
    }

    /**
     * @param array|null $etots
     */
    public function setEtots(?array $etots): void
    {
        $this->etots = $etots;
    }

    /**
     * @return array|null
     */
    public function getExots(): ?array
    {
        return $this->exots;
    }

    /**
     * @param array|null $exots
     */
    public function setExots(?array $exots): void
    {
        $this->exots = $exots;
    }

    /**
     * @return array|null
     */
    public function getSobts(): ?array
    {
        return $this->sobts;
    }

    /**
     * @param array|null $sobts
     */
    public function setSobts(?array $sobts): void
    {
        $this->sobts = $sobts;
    }

    /**
     * @return array|null
     */
    public function getStets(): ?array
    {
        return $this->stets;
    }

    /**
     * @param array|null $stets
     */
    public function setStets(?array $stets): void
    {
        $this->stets = $stets;
    }

    /**
     * @return array|null
     */
    public function getStsts(): ?array
    {
        return $this->ststs;
    }

    /**
     * @param array|null $ststs
     */
    public function setStsts(?array $ststs): void
    {
        $this->ststs = $ststs;
    }

    /**
     * @return array|null
     */
    public function getTobts(): ?array
    {
        return $this->tobts;
    }

    /**
     * @param array|null $tobts
     */
    public function setTobts(?array $tobts): void
    {
        $this->tobts = $tobts;
    }

    /**
     * @return array|null
     */
    public function getTsats(): ?array
    {
        return $this->tsats;
    }

    /**
     * @param array|null $tsats
     */
    public function setTsats(?array $tsats): void
    {
        $this->tsats = $tsats;
    }

    /**
     * @return array|null
     */
    public function getTtots(): ?array
    {
        return $this->ttots;
    }

    /**
     * @param array|null $ttots
     */
    public function setTtots(?array $ttots): void
    {
        $this->ttots = $ttots;
    }

    /**
     * @return object|null
     */
    public function getDepartureMeta(): ?object
    {
        return $this->departure_meta;
    }

    /**
     * @param object|null $departure_meta
     */
    public function setDepartureMeta(?object $departure_meta): void
    {
        $this->departure_meta = $departure_meta;
    }
}
