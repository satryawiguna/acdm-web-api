<?php


namespace App\Service\Contracts\Element\Request;

use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="ElementIdRequest",
 *     title="Element Id Request",
 *     description="Element id request schema",
 *     required={"id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Id property"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateElementRequest",
 *     title="Element Request",
 *     description="Element request schema",
 *     required={"id", "departure_id", "role_initialize_id", "role_origin_id"}
 * )
 */
class UpdateElementRequest extends IdentityAuditableRequest
{
    /**
     * @OA\Property(
     *     property="departure_id",
     *     type="integer",
     *     format="int64",
     *     description="Departure id property"
     * )
     */
    public int $departure_id;

    public ?DateTime $acgt;

    public int $acgtable_id;

    public string $acgtable_type;

    public ?DateTime $aczt;

    public int $acztable_id;

    public string $acztable_type;

    public ?int $adit;

    public int $aditable_id;

    public string $aditable_type;

    public ?DateTime $aegt;

    public int $aegtable_id;

    public string $aegtable_type;

    public ?DateTime $aezt;

    public int $aeztable_id;

    public string $aeztable_type;

    public ?DateTime $aght;

    public int $aghtable_id;

    public string $aghtable_type;

    public ?DateTime $aobt;

    public int $aobtable_id;

    public string $aobtable_type;

    public ?DateTime $ardt;

    public int $ardtable_id;

    public string $ardtable_type;

    public ?DateTime $arzt;

    public int $arztable_id;

    public string $arztable_type;

    public ?DateTime $asbt;

    public int $asbtable_id;

    public string $asbtable_type;

    public ?DateTime $asrt;

    public int $asrtable_id;

    public string $asrtable_type;

    public ?DateTime $atet;

    public int $atetable_id;

    public string $atetable_type;

    public ?DateTime $atot;

    public int $atotable_id;

    public string $atotable_type;

    public ?DateTime $atst;

    public int $atstable_id;

    public string $atstable_type;

    public ?int $attt;

    public int $atttable_id;

    public string $atttable_type;

    public ?int $axot;

    public int $axotable_id;

    public string $axotable_type;

    public ?DateTime $azat;

    public int $azatable_id;

    public string $azatable_type;

    public ?DateTime $ctot;

    public int $ctotable_id;

    public string $ctotable_type;

    public ?DateTime $eczt;

    public int $ecztable_id;

    public string $ecztable_type;

    public ?int $edit;

    public int $editable_id;

    public string $editable_type;

    public ?DateTime $eezt;

    public int $eeztable_id;

    public string $eeztable_type;

    public ?DateTime $eobt;

    public int $eobtable_id;

    public string $eobtable_type;

    public ?DateTime $erzt;

    public int $erztable_id;

    public string $erzable_type;

    public ?DateTime $etot;

    public int $etotable_id;

    public string $etotable_type;

    public ?int $exot;

    public int $exotable_id;

    public string $exotable_type;

    public ?DateTime $sobt;

    public int $sobtable_id;

    public string $sobtable_type;

    public ?DateTime $stet;

    public int $stetable_id;

    public string $stetable_type;

    public ?DateTime $stst;

    public int $ststable_id;

    public string $ststable_type;

    public ?DateTime $tobt;

    public int $tobtable_id;

    public string $tobtable_type;

    public ?DateTime $tsat;

    public int $tsatable_id;

    public string $tsatable_type;

    public ?DateTime $ttot;

    public int $ttotable_id;

    public string $ttotable_type;

    /**
     * @OA\Property(
     *     property="reason",
     *     type="string",
     *     description="Reason property"
     * )
     */
    public ?string $reason;

    /**
     * @OA\Property(
     *     property="init",
     *     type="boolean",
     *     description="Init property"
     * )
     */
    public bool $init;

    /**
     * @return int
     */
    public function getDepartureId(): int
    {
        return $this->departure_id;
    }

    /**
     * @param int $departure_id
     */
    public function setDepartureId(int $departure_id): void
    {
        $this->departure_id = $departure_id;
    }

    /**
     * @return DateTime|null
     */
    public function getAcgt(): ?DateTime
    {
        return $this->acgt;
    }

    /**
     * @param DateTime|null $acgt
     */
    public function setAcgt(?DateTime $acgt): void
    {
        $this->acgt = $acgt;
    }

    /**
     * @return int
     */
    public function getAcgtableId(): int
    {
        return $this->acgtable_id;
    }

    /**
     * @param int $acgtable_id
     */
    public function setAcgtableId(int $acgtable_id): void
    {
        $this->acgtable_id = $acgtable_id;
    }

    /**
     * @return string
     */
    public function getAcgtableType(): string
    {
        return $this->acgtable_type;
    }

    /**
     * @param string $acgtable_type
     */
    public function setAcgtableType(string $acgtable_type): void
    {
        $this->acgtable_type = $acgtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAczt(): ?DateTime
    {
        return $this->aczt;
    }

    /**
     * @param DateTime|null $aczt
     */
    public function setAczt(?DateTime $aczt): void
    {
        $this->aczt = $aczt;
    }

    /**
     * @return int
     */
    public function getAcztableId(): int
    {
        return $this->acztable_id;
    }

    /**
     * @param int $acztable_id
     */
    public function setAcztableId(int $acztable_id): void
    {
        $this->acztable_id = $acztable_id;
    }

    /**
     * @return string
     */
    public function getAcztableType(): string
    {
        return $this->acztable_type;
    }

    /**
     * @param string $acztable_type
     */
    public function setAcztableType(string $acztable_type): void
    {
        $this->acztable_type = $acztable_type;
    }

    /**
     * @return int|null
     */
    public function getAdit(): ?int
    {
        return $this->adit;
    }

    /**
     * @param int|null $adit
     */
    public function setAdit(?int $adit): void
    {
        $this->adit = $adit;
    }

    /**
     * @return int
     */
    public function getAditableId(): int
    {
        return $this->aditable_id;
    }

    /**
     * @param int $aditable_id
     */
    public function setAditableId(int $aditable_id): void
    {
        $this->aditable_id = $aditable_id;
    }

    /**
     * @return string
     */
    public function getAditableType(): string
    {
        return $this->aditable_type;
    }

    /**
     * @param string $aditable_type
     */
    public function setAditableType(string $aditable_type): void
    {
        $this->aditable_type = $aditable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAegt(): ?DateTime
    {
        return $this->aegt;
    }

    /**
     * @param DateTime|null $aegt
     */
    public function setAegt(?DateTime $aegt): void
    {
        $this->aegt = $aegt;
    }

    /**
     * @return int
     */
    public function getAegtableId(): int
    {
        return $this->aegtable_id;
    }

    /**
     * @param int $aegtable_id
     */
    public function setAegtableId(int $aegtable_id): void
    {
        $this->aegtable_id = $aegtable_id;
    }

    /**
     * @return string
     */
    public function getAegtableType(): string
    {
        return $this->aegtable_type;
    }

    /**
     * @param string $aegtable_type
     */
    public function setAegtableType(string $aegtable_type): void
    {
        $this->aegtable_type = $aegtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAezt(): ?DateTime
    {
        return $this->aezt;
    }

    /**
     * @param DateTime|null $aezt
     */
    public function setAezt(?DateTime $aezt): void
    {
        $this->aezt = $aezt;
    }

    /**
     * @return int
     */
    public function getAeztableId(): int
    {
        return $this->aeztable_id;
    }

    /**
     * @param int $aeztable_id
     */
    public function setAeztableId(int $aeztable_id): void
    {
        $this->aeztable_id = $aeztable_id;
    }

    /**
     * @return string
     */
    public function getAeztableType(): string
    {
        return $this->aeztable_type;
    }

    /**
     * @param string $aeztable_type
     */
    public function setAeztableType(string $aeztable_type): void
    {
        $this->aeztable_type = $aeztable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAght(): ?DateTime
    {
        return $this->aght;
    }

    /**
     * @param DateTime|null $aght
     */
    public function setAght(?DateTime $aght): void
    {
        $this->aght = $aght;
    }

    /**
     * @return int
     */
    public function getAghtableId(): int
    {
        return $this->aghtable_id;
    }

    /**
     * @param int $aghtable_id
     */
    public function setAghtableId(int $aghtable_id): void
    {
        $this->aghtable_id = $aghtable_id;
    }

    /**
     * @return string
     */
    public function getAghtableType(): string
    {
        return $this->aghtable_type;
    }

    /**
     * @param string $aghtable_type
     */
    public function setAghtableType(string $aghtable_type): void
    {
        $this->aghtable_type = $aghtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAobt(): ?DateTime
    {
        return $this->aobt;
    }

    /**
     * @param DateTime|null $aobt
     */
    public function setAobt(?DateTime $aobt): void
    {
        $this->aobt = $aobt;
    }

    /**
     * @return int
     */
    public function getAobtableId(): int
    {
        return $this->aobtable_id;
    }

    /**
     * @param int $aobtable_id
     */
    public function setAobtableId(int $aobtable_id): void
    {
        $this->aobtable_id = $aobtable_id;
    }

    /**
     * @return string
     */
    public function getAobtableType(): string
    {
        return $this->aobtable_type;
    }

    /**
     * @param string $aobtable_type
     */
    public function setAobtableType(string $aobtable_type): void
    {
        $this->aobtable_type = $aobtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getArdt(): ?DateTime
    {
        return $this->ardt;
    }

    /**
     * @param DateTime|null $ardt
     */
    public function setArdt(?DateTime $ardt): void
    {
        $this->ardt = $ardt;
    }

    /**
     * @return int
     */
    public function getArdtableId(): int
    {
        return $this->ardtable_id;
    }

    /**
     * @param int $ardtable_id
     */
    public function setArdtableId(int $ardtable_id): void
    {
        $this->ardtable_id = $ardtable_id;
    }

    /**
     * @return string
     */
    public function getArdtableType(): string
    {
        return $this->ardtable_type;
    }

    /**
     * @param string $ardtable_type
     */
    public function setArdtableType(string $ardtable_type): void
    {
        $this->ardtable_type = $ardtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getArzt(): ?DateTime
    {
        return $this->arzt;
    }

    /**
     * @param DateTime|null $arzt
     */
    public function setArzt(?DateTime $arzt): void
    {
        $this->arzt = $arzt;
    }

    /**
     * @return int
     */
    public function getArztableId(): int
    {
        return $this->arztable_id;
    }

    /**
     * @param int $arztable_id
     */
    public function setArztableId(int $arztable_id): void
    {
        $this->arztable_id = $arztable_id;
    }

    /**
     * @return string
     */
    public function getArztableType(): string
    {
        return $this->arztable_type;
    }

    /**
     * @param string $arztable_type
     */
    public function setArztableType(string $arztable_type): void
    {
        $this->arztable_type = $arztable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAsbt(): ?DateTime
    {
        return $this->asbt;
    }

    /**
     * @param DateTime|null $asbt
     */
    public function setAsbt(?DateTime $asbt): void
    {
        $this->asbt = $asbt;
    }

    /**
     * @return int
     */
    public function getAsbtableId(): int
    {
        return $this->asbtable_id;
    }

    /**
     * @param int $asbtable_id
     */
    public function setAsbtableId(int $asbtable_id): void
    {
        $this->asbtable_id = $asbtable_id;
    }

    /**
     * @return string
     */
    public function getAsbtableType(): string
    {
        return $this->asbtable_type;
    }

    /**
     * @param string $asbtable_type
     */
    public function setAsbtableType(string $asbtable_type): void
    {
        $this->asbtable_type = $asbtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAsrt(): ?DateTime
    {
        return $this->asrt;
    }

    /**
     * @param DateTime|null $asrt
     */
    public function setAsrt(?DateTime $asrt): void
    {
        $this->asrt = $asrt;
    }

    /**
     * @return int
     */
    public function getAsrtableId(): int
    {
        return $this->asrtable_id;
    }

    /**
     * @param int $asrtable_id
     */
    public function setAsrtableId(int $asrtable_id): void
    {
        $this->asrtable_id = $asrtable_id;
    }

    /**
     * @return string
     */
    public function getAsrtableType(): string
    {
        return $this->asrtable_type;
    }

    /**
     * @param string $asrtable_type
     */
    public function setAsrtableType(string $asrtable_type): void
    {
        $this->asrtable_type = $asrtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAtet(): ?DateTime
    {
        return $this->atet;
    }

    /**
     * @param DateTime|null $atet
     */
    public function setAtet(?DateTime $atet): void
    {
        $this->atet = $atet;
    }

    /**
     * @return int
     */
    public function getAtetableId(): int
    {
        return $this->atetable_id;
    }

    /**
     * @param int $atetable_id
     */
    public function setAtetableId(int $atetable_id): void
    {
        $this->atetable_id = $atetable_id;
    }

    /**
     * @return string
     */
    public function getAtetableType(): string
    {
        return $this->atetable_type;
    }

    /**
     * @param string $atetable_type
     */
    public function setAtetableType(string $atetable_type): void
    {
        $this->atetable_type = $atetable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAtot(): ?DateTime
    {
        return $this->atot;
    }

    /**
     * @param DateTime|null $atot
     */
    public function setAtot(?DateTime $atot): void
    {
        $this->atot = $atot;
    }

    /**
     * @return int
     */
    public function getAtotableId(): int
    {
        return $this->atotable_id;
    }

    /**
     * @param int $atotable_id
     */
    public function setAtotableId(int $atotable_id): void
    {
        $this->atotable_id = $atotable_id;
    }

    /**
     * @return string
     */
    public function getAtotableType(): string
    {
        return $this->atotable_type;
    }

    /**
     * @param string $atotable_type
     */
    public function setAtotableType(string $atotable_type): void
    {
        $this->atotable_type = $atotable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAtst(): ?DateTime
    {
        return $this->atst;
    }

    /**
     * @param DateTime|null $atst
     */
    public function setAtst(?DateTime $atst): void
    {
        $this->atst = $atst;
    }

    /**
     * @return int
     */
    public function getAtstableId(): int
    {
        return $this->atstable_id;
    }

    /**
     * @param int $atstable_id
     */
    public function setAtstableId(int $atstable_id): void
    {
        $this->atstable_id = $atstable_id;
    }

    /**
     * @return string
     */
    public function getAtstableType(): string
    {
        return $this->atstable_type;
    }

    /**
     * @param string $atstable_type
     */
    public function setAtstableType(string $atstable_type): void
    {
        $this->atstable_type = $atstable_type;
    }

    /**
     * @return int|null
     */
    public function getAttt(): ?int
    {
        return $this->attt;
    }

    /**
     * @param int|null $attt
     */
    public function setAttt(?int $attt): void
    {
        $this->attt = $attt;
    }

    /**
     * @return int
     */
    public function getAtttableId(): int
    {
        return $this->atttable_id;
    }

    /**
     * @param int $atttable_id
     */
    public function setAtttableId(int $atttable_id): void
    {
        $this->atttable_id = $atttable_id;
    }

    /**
     * @return string
     */
    public function getAtttableType(): string
    {
        return $this->atttable_type;
    }

    /**
     * @param string $atttable_type
     */
    public function setAtttableType(string $atttable_type): void
    {
        $this->atttable_type = $atttable_type;
    }

    /**
     * @return int|null
     */
    public function getAxot(): ?int
    {
        return $this->axot;
    }

    /**
     * @param int|null $axot
     */
    public function setAxot(?int $axot): void
    {
        $this->axot = $axot;
    }

    /**
     * @return int
     */
    public function getAxotableId(): int
    {
        return $this->axotable_id;
    }

    /**
     * @param int $axotable_id
     */
    public function setAxotableId(int $axotable_id): void
    {
        $this->axotable_id = $axotable_id;
    }

    /**
     * @return string
     */
    public function getAxotableType(): string
    {
        return $this->axotable_type;
    }

    /**
     * @param string $axotable_type
     */
    public function setAxotableType(string $axotable_type): void
    {
        $this->axotable_type = $axotable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getAzat(): ?DateTime
    {
        return $this->azat;
    }

    /**
     * @param DateTime|null $azat
     */
    public function setAzat(?DateTime $azat): void
    {
        $this->azat = $azat;
    }

    /**
     * @return int
     */
    public function getAzatableId(): int
    {
        return $this->azatable_id;
    }

    /**
     * @param int $azatable_id
     */
    public function setAzatableId(int $azatable_id): void
    {
        $this->azatable_id = $azatable_id;
    }

    /**
     * @return string
     */
    public function getAzatableType(): string
    {
        return $this->azatable_type;
    }

    /**
     * @param string $azatable_type
     */
    public function setAzatableType(string $azatable_type): void
    {
        $this->azatable_type = $azatable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getCtot(): ?DateTime
    {
        return $this->ctot;
    }

    /**
     * @param DateTime|null $ctot
     */
    public function setCtot(?DateTime $ctot): void
    {
        $this->ctot = $ctot;
    }

    /**
     * @return int
     */
    public function getCtotableId(): int
    {
        return $this->ctotable_id;
    }

    /**
     * @param int $ctotable_id
     */
    public function setCtotableId(int $ctotable_id): void
    {
        $this->ctotable_id = $ctotable_id;
    }

    /**
     * @return string
     */
    public function getCtotableType(): string
    {
        return $this->ctotable_type;
    }

    /**
     * @param string $ctotable_type
     */
    public function setCtotableType(string $ctotable_type): void
    {
        $this->ctotable_type = $ctotable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getEczt(): ?DateTime
    {
        return $this->eczt;
    }

    /**
     * @param DateTime|null $eczt
     */
    public function setEczt(?DateTime $eczt): void
    {
        $this->eczt = $eczt;
    }

    /**
     * @return int
     */
    public function getEcztableId(): int
    {
        return $this->ecztable_id;
    }

    /**
     * @param int $ecztable_id
     */
    public function setEcztableId(int $ecztable_id): void
    {
        $this->ecztable_id = $ecztable_id;
    }

    /**
     * @return string
     */
    public function getEcztableType(): string
    {
        return $this->ecztable_type;
    }

    /**
     * @param string $ecztable_type
     */
    public function setEcztableType(string $ecztable_type): void
    {
        $this->ecztable_type = $ecztable_type;
    }

    /**
     * @return int|null
     */
    public function getEdit(): ?int
    {
        return $this->edit;
    }

    /**
     * @param int|null $edit
     */
    public function setEdit(?int $edit): void
    {
        $this->edit = $edit;
    }

    /**
     * @return int
     */
    public function getEditableId(): int
    {
        return $this->editable_id;
    }

    /**
     * @param int $editable_id
     */
    public function setEditableId(int $editable_id): void
    {
        $this->editable_id = $editable_id;
    }

    /**
     * @return string
     */
    public function getEditableType(): string
    {
        return $this->editable_type;
    }

    /**
     * @param string $editable_type
     */
    public function setEditableType(string $editable_type): void
    {
        $this->editable_type = $editable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getEezt(): ?DateTime
    {
        return $this->eezt;
    }

    /**
     * @param DateTime|null $eezt
     */
    public function setEezt(?DateTime $eezt): void
    {
        $this->eezt = $eezt;
    }

    /**
     * @return int
     */
    public function getEeztableId(): int
    {
        return $this->eeztable_id;
    }

    /**
     * @param int $eeztable_id
     */
    public function setEeztableId(int $eeztable_id): void
    {
        $this->eeztable_id = $eeztable_id;
    }

    /**
     * @return string
     */
    public function getEeztableType(): string
    {
        return $this->eeztable_type;
    }

    /**
     * @param string $eeztable_type
     */
    public function setEeztableType(string $eeztable_type): void
    {
        $this->eeztable_type = $eeztable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getEobt(): ?DateTime
    {
        return $this->eobt;
    }

    /**
     * @param DateTime|null $eobt
     */
    public function setEobt(?DateTime $eobt): void
    {
        $this->eobt = $eobt;
    }

    /**
     * @return int
     */
    public function getEobtableId(): int
    {
        return $this->eobtable_id;
    }

    /**
     * @param int $eobtable_id
     */
    public function setEobtableId(int $eobtable_id): void
    {
        $this->eobtable_id = $eobtable_id;
    }

    /**
     * @return string
     */
    public function getEobtableType(): string
    {
        return $this->eobtable_type;
    }

    /**
     * @param string $eobtable_type
     */
    public function setEobtableType(string $eobtable_type): void
    {
        $this->eobtable_type = $eobtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getErzt(): ?DateTime
    {
        return $this->erzt;
    }

    /**
     * @param DateTime|null $erzt
     */
    public function setErzt(?DateTime $erzt): void
    {
        $this->erzt = $erzt;
    }

    /**
     * @return int
     */
    public function getErztableId(): int
    {
        return $this->erztable_id;
    }

    /**
     * @param int $erztable_id
     */
    public function setErztableId(int $erztable_id): void
    {
        $this->erztable_id = $erztable_id;
    }

    /**
     * @return string
     */
    public function getErzableType(): string
    {
        return $this->erzable_type;
    }

    /**
     * @param string $erzable_type
     */
    public function setErzableType(string $erzable_type): void
    {
        $this->erzable_type = $erzable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getEtot(): ?DateTime
    {
        return $this->etot;
    }

    /**
     * @param DateTime|null $etot
     */
    public function setEtot(?DateTime $etot): void
    {
        $this->etot = $etot;
    }

    /**
     * @return int
     */
    public function getEtotableId(): int
    {
        return $this->etotable_id;
    }

    /**
     * @param int $etotable_id
     */
    public function setEtotableId(int $etotable_id): void
    {
        $this->etotable_id = $etotable_id;
    }

    /**
     * @return string
     */
    public function getEtotableType(): string
    {
        return $this->etotable_type;
    }

    /**
     * @param string $etotable_type
     */
    public function setEtotableType(string $etotable_type): void
    {
        $this->etotable_type = $etotable_type;
    }

    /**
     * @return int|null
     */
    public function getExot(): ?int
    {
        return $this->exot;
    }

    /**
     * @param int|null $exot
     */
    public function setExot(?int $exot): void
    {
        $this->exot = $exot;
    }

    /**
     * @return int
     */
    public function getExotableId(): int
    {
        return $this->exotable_id;
    }

    /**
     * @param int $exotable_id
     */
    public function setExotableId(int $exotable_id): void
    {
        $this->exotable_id = $exotable_id;
    }

    /**
     * @return string
     */
    public function getExotableType(): string
    {
        return $this->exotable_type;
    }

    /**
     * @param string $exotable_type
     */
    public function setExotableType(string $exotable_type): void
    {
        $this->exotable_type = $exotable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getSobt(): ?DateTime
    {
        return $this->sobt;
    }

    /**
     * @param DateTime|null $sobt
     */
    public function setSobt(?DateTime $sobt): void
    {
        $this->sobt = $sobt;
    }

    /**
     * @return int
     */
    public function getSobtableId(): int
    {
        return $this->sobtable_id;
    }

    /**
     * @param int $sobtable_id
     */
    public function setSobtableId(int $sobtable_id): void
    {
        $this->sobtable_id = $sobtable_id;
    }

    /**
     * @return string
     */
    public function getSobtableType(): string
    {
        return $this->sobtable_type;
    }

    /**
     * @param string $sobtable_type
     */
    public function setSobtableType(string $sobtable_type): void
    {
        $this->sobtable_type = $sobtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getStet(): ?DateTime
    {
        return $this->stet;
    }

    /**
     * @param DateTime|null $stet
     */
    public function setStet(?DateTime $stet): void
    {
        $this->stet = $stet;
    }

    /**
     * @return int
     */
    public function getStetableId(): int
    {
        return $this->stetable_id;
    }

    /**
     * @param int $stetable_id
     */
    public function setStetableId(int $stetable_id): void
    {
        $this->stetable_id = $stetable_id;
    }

    /**
     * @return string
     */
    public function getStetableType(): string
    {
        return $this->stetable_type;
    }

    /**
     * @param string $stetable_type
     */
    public function setStetableType(string $stetable_type): void
    {
        $this->stetable_type = $stetable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getStst(): ?DateTime
    {
        return $this->stst;
    }

    /**
     * @param DateTime|null $stst
     */
    public function setStst(?DateTime $stst): void
    {
        $this->stst = $stst;
    }

    /**
     * @return int
     */
    public function getStstableId(): int
    {
        return $this->ststable_id;
    }

    /**
     * @param int $ststable_id
     */
    public function setStstableId(int $ststable_id): void
    {
        $this->ststable_id = $ststable_id;
    }

    /**
     * @return string
     */
    public function getStstableType(): string
    {
        return $this->ststable_type;
    }

    /**
     * @param string $ststable_type
     */
    public function setStstableType(string $ststable_type): void
    {
        $this->ststable_type = $ststable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getTobt(): ?DateTime
    {
        return $this->tobt;
    }

    /**
     * @param DateTime|null $tobt
     */
    public function setTobt(?DateTime $tobt): void
    {
        $this->tobt = $tobt;
    }

    /**
     * @return int
     */
    public function getTobtableId(): int
    {
        return $this->tobtable_id;
    }

    /**
     * @param int $tobtable_id
     */
    public function setTobtableId(int $tobtable_id): void
    {
        $this->tobtable_id = $tobtable_id;
    }

    /**
     * @return string
     */
    public function getTobtableType(): string
    {
        return $this->tobtable_type;
    }

    /**
     * @param string $tobtable_type
     */
    public function setTobtableType(string $tobtable_type): void
    {
        $this->tobtable_type = $tobtable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getTsat(): ?DateTime
    {
        return $this->tsat;
    }

    /**
     * @param DateTime|null $tsat
     */
    public function setTsat(?DateTime $tsat): void
    {
        $this->tsat = $tsat;
    }

    /**
     * @return int
     */
    public function getTsatableId(): int
    {
        return $this->tsatable_id;
    }

    /**
     * @param int $tsatable_id
     */
    public function setTsatableId(int $tsatable_id): void
    {
        $this->tsatable_id = $tsatable_id;
    }

    /**
     * @return string
     */
    public function getTsatableType(): string
    {
        return $this->tsatable_type;
    }

    /**
     * @param string $tsatable_type
     */
    public function setTsatableType(string $tsatable_type): void
    {
        $this->tsatable_type = $tsatable_type;
    }

    /**
     * @return DateTime|null
     */
    public function getTtot(): ?DateTime
    {
        return $this->ttot;
    }

    /**
     * @param DateTime|null $ttot
     */
    public function setTtot(?DateTime $ttot): void
    {
        $this->ttot = $ttot;
    }

    /**
     * @return int
     */
    public function getTtotableId(): int
    {
        return $this->ttotable_id;
    }

    /**
     * @param int $ttotable_id
     */
    public function setTtotableId(int $ttotable_id): void
    {
        $this->ttotable_id = $ttotable_id;
    }

    /**
     * @return string
     */
    public function getTtotableType(): string
    {
        return $this->ttotable_type;
    }

    /**
     * @param string $ttotable_type
     */
    public function setTtotableType(string $ttotable_type): void
    {
        $this->ttotable_type = $ttotable_type;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return bool
     */
    public function isInit(): bool
    {
        return $this->init;
    }

    /**
     * @param bool $init
     */
    public function setInit(bool $init): void
    {
        $this->init = $init;
    }
}

/**
 * @OA\Schema(
 *     schema="AcgtUpdateRequest",
 *     title="Acgt Update Request",
 *     description="Acgt update request schema",
 *     required={"id", "departure_id", "acgt", "init", "acgtable_id", "acgtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="acgt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Acgt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="acgtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Acgtable id property"
 *              ),
 *              @OA\Property(
 *                  property="acgtable_type",
 *                  type="string",
 *                  description="Acgtable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AcztUpdateRequest",
 *     title="Aczt Update Request",
 *     description="Aczt update request schema",
 *     required={"id", "departure_id", "acgt", "init", "acztable_id", "acztable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="aczt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Aczt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="acztable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Acztable id property"
 *              ),
 *              @OA\Property(
 *                  property="acztable_type",
 *                  type="string",
 *                  description="Acztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AditUpdateRequest",
 *     title="Adit Update Request",
 *     description="Adit update request schema",
 *     required={"id", "departure_id", "adit", "init", "aditable_id", "aditable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="adit",
 *                  type="string",
 *                  format="date-time",
 *                  description="Adit property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="aditable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Aditable id property"
 *              ),
 *              @OA\Property(
 *                  property="aditable_type",
 *                  type="string",
 *                  description="Aditable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AegtUpdateRequest",
 *     title="Aegt Update Request",
 *     description="Aegt update request schema",
 *     required={"id", "departure_id", "aegt", "init", "aegtable_id", "aegtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="aegt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Aegt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="aegtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Aegtable id property"
 *              ),
 *              @OA\Property(
 *                  property="aegtable_type",
 *                  type="string",
 *                  description="Aegtable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AeztUpdateRequest",
 *     title="Aezt Update Request",
 *     description="Aezt update request schema",
 *     required={"id", "departure_id", "aezt", "init", "aeztable_id", "aeztable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="aezt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Aezt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="aeztable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Aeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="aeztable_type",
 *                  type="string",
 *                  description="Aeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AghtUpdateRequest",
 *     title="Aght Update Request",
 *     description="Aght update request schema",
 *     required={"id", "departure_id", "aght", "init", "aghtable_id", "aghtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="aght",
 *                  type="string",
 *                  format="date-time",
 *                  description="Aght property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="aghtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Aghtable id property"
 *              ),
 *              @OA\Property(
 *                  property="aghtable_type",
 *                  type="string",
 *                  description="Aghtable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AobtUpdateRequest",
 *     title="Aobt Update Request",
 *     description="Aobt update request schema",
 *     required={"id", "departure_id", "aobt", "init", "aobtable_id", "aobtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="aobt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Aobt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="aobtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Aobtable id property"
 *              ),
 *              @OA\Property(
 *                  property="aobtable_type",
 *                  type="string",
 *                  description="Aobtable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ArdtUpdateRequest",
 *     title="Ardt Update Request",
 *     description="Ardt update request schema",
 *     required={"id", "departure_id", "ardt", "init", "ardtable_id", "ardtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="ardt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Ardt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="ardtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Ardtable id property"
 *              ),
 *              @OA\Property(
 *                  property="ardtable_type",
 *                  type="string",
 *                  description="Ardtable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ArztUpdateRequest",
 *     title="Arzt Update Request",
 *     description="Arzt update request schema",
 *     required={"id", "departure_id", "arzt", "init", "arztable_id", "arztable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="arzt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Arzt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="arztable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Arztable id property"
 *              ),
 *              @OA\Property(
 *                  property="arztable_type",
 *                  type="string",
 *                  description="Arztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AsbtUpdateRequest",
 *     title="Asbt Update Request",
 *     description="Asbt update request schema",
 *     required={"id", "departure_id", "asbt", "init", "asbtable_id", "asbtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="asbt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Asbt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="asbtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Arztable id property"
 *              ),
 *              @OA\Property(
 *                  property="asbtable_type",
 *                  type="string",
 *                  description="Arztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AsrtUpdateRequest",
 *     title="Asrt Update Request",
 *     description="Asrt update request schema",
 *     required={"id", "departure_id", "asrt", "init", "asrtable_id", "asrtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="asrt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Asrt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="asrtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Asrtable id property"
 *              ),
 *              @OA\Property(
 *                  property="asrtable_type",
 *                  type="string",
 *                  description="Asrtable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AtetUpdateRequest",
 *     title="Atet Update Request",
 *     description="Atet update request schema",
 *     required={"id", "departure_id", "atet", "init", "atetable_id", "atetable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="atet",
 *                  type="string",
 *                  format="date-time",
 *                  description="Atet property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="atetable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Atetable id property"
 *              ),
 *              @OA\Property(
 *                  property="atetable_type",
 *                  type="string",
 *                  description="Atetable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AtotUpdateRequest",
 *     title="Atot Update Request",
 *     description="Atot update request schema",
 *     required={"id", "departure_id", "atot", "init", "atotable_id", "atotable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="atot",
 *                  type="string",
 *                  format="date-time",
 *                  description="Atot property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="atotable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Atotable id property"
 *              ),
 *              @OA\Property(
 *                  property="atotable_type",
 *                  type="string",
 *                  description="Atotable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AtstUpdateRequest",
 *     title="Atst Update Request",
 *     description="Atst update request schema",
 *     required={"id", "departure_id", "atst", "init", "atstable_id", "atstable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="atst",
 *                  type="string",
 *                  format="date-time",
 *                  description="Atst property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="atstable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Atstable id property"
 *              ),
 *              @OA\Property(
 *                  property="atstable_type",
 *                  type="string",
 *                  description="Atstable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AtttUpdateRequest",
 *     title="Attt Update Request",
 *     description="Attt update request schema",
 *     required={"id", "departure_id", "attt", "init", "atttable_id", "atttable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="attt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Attt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="atttable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Atttable id property"
 *              ),
 *              @OA\Property(
 *                  property="atttable_type",
 *                  type="string",
 *                  description="Atttable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AxotUpdateRequest",
 *     title="Axot Update Request",
 *     description="Axot update request schema",
 *     required={"id", "departure_id", "axot", "init", "axotable_id", "axotable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="axot",
 *                  type="string",
 *                  format="date-time",
 *                  description="Axot property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="axotable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Axotable id property"
 *              ),
 *              @OA\Property(
 *                  property="axotable_type",
 *                  type="string",
 *                  description="Axotable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="AzatUpdateRequest",
 *     title="Azat Update Request",
 *     description="Azat update request schema",
 *     required={"id", "departure_id", "azat", "init", "azatable_id", "azatable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="azat",
 *                  type="string",
 *                  format="date-time",
 *                  description="Azat property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="azatable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Azatable id property"
 *              ),
 *              @OA\Property(
 *                  property="azatable_type",
 *                  type="string",
 *                  description="Azatable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="CtotUpdateRequest",
 *     title="Ctot Update Request",
 *     description="Ctot update request schema",
 *     required={"id", "departure_id", "ctot", "init", "ctotable_id", "ctotable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="ctot",
 *                  type="string",
 *                  format="date-time",
 *                  description="Ctot property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="ctotable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Ctotable id property"
 *              ),
 *              @OA\Property(
 *                  property="ctotable_type",
 *                  type="string",
 *                  description="Ctotable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="EcztUpdateRequest",
 *     title="Eczt Update Request",
 *     description="Eczt update request schema",
 *     required={"id", "departure_id", "eczt", "init", "ecztable_id", "ecztable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="eczt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Eczt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="ecztable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Ecztable id property"
 *              ),
 *              @OA\Property(
 *                  property="ecztable_type",
 *                  type="string",
 *                  description="Ecztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="EditUpdateRequest",
 *     title="Edit Update Request",
 *     description="Edit update request schema",
 *     required={"id", "departure_id", "edit", "init", "editable_id", "editable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="edit",
 *                  type="string",
 *                  format="date-time",
 *                  description="Edit property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="editable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Editable id property"
 *              ),
 *              @OA\Property(
 *                  property="editable_type",
 *                  type="string",
 *                  description="Editable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="EeztUpdateRequest",
 *     title="Eezt Update Request",
 *     description="Eezt update request schema",
 *     required={"id", "departure_id", "eezt", "init", "eeztable_id", "eeztable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="eezt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Eezt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="eeztable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="eeztable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="EobtUpdateRequest",
 *     title="Eobt Update Request",
 *     description="Eobt update request schema",
 *     required={"id", "departure_id", "eobt", "init", "eobtable_id", "eobtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="eobt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Eobt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="eobtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="eobtable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ErztUpdateRequest",
 *     title="Erzt Update Request",
 *     description="Erzt update request schema",
 *     required={"id", "departure_id", "erzt", "init", "erztable_id", "erztable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="erzt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Erzt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="erztable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="erztable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="EtotUpdateRequest",
 *     title="Etot Update Request",
 *     description="Etot update request schema",
 *     required={"id", "departure_id", "etot", "init", "etotable_id", "etotable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="etot",
 *                  type="string",
 *                  format="date-time",
 *                  description="Etot property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="etotable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="etotable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ExotUpdateRequest",
 *     title="Exot Update Request",
 *     description="Exot update request schema",
 *     required={"id", "departure_id", "exot", "init", "exotable_id", "exotable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="exot",
 *                  type="string",
 *                  format="date-time",
 *                  description="Exot property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="exotable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="exotable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="SobtUpdateRequest",
 *     title="Sobt Update Request",
 *     description="Sobt update request schema",
 *     required={"id", "departure_id", "sobt", "init", "sobtable_id", "sobtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="sobt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Sobt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="sobtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="sobtable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="StetUpdateRequest",
 *     title="Stet Update Request",
 *     description="Stet update request schema",
 *     required={"id", "departure_id", "stet", "init", "stetable_id", "stetable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="stet",
 *                  type="string",
 *                  format="date-time",
 *                  description="Stet property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="stetable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="stetable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="StstUpdateRequest",
 *     title="Stst Update Request",
 *     description="Stst update request schema",
 *     required={"id", "departure_id", "stst", "init", "ststable_id", "ststable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="stst",
 *                  type="string",
 *                  format="date-time",
 *                  description="Stst property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="ststable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="ststable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="TobtUpdateRequest",
 *     title="Tobt Update Request",
 *     description="Tobt update request schema",
 *     required={"id", "departure_id", "tobt", "init", "tobtable_id", "tobtable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="tobt",
 *                  type="string",
 *                  format="date-time",
 *                  description="Tobt property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="tobtable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="tobtable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="TsatUpdateRequest",
 *     title="Tsat Update Request",
 *     description="Tsat update request schema",
 *     required={"id", "departure_id", "tsat", "init", "tsatable_id", "tsatable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="tsat",
 *                  type="string",
 *                  format="date-time",
 *                  description="Tsat property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="tsatable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="tsatable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="TtotUpdateRequest",
 *     title="Ttot Update Request",
 *     description="Ttot update request schema",
 *     required={"id", "departure_id", "ttot", "init", "ttotable_id", "ttotable_type"},
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/ElementIdRequest"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="ttot",
 *                  type="string",
 *                  format="date-time",
 *                  description="Ttot property",
 *                  example="YYYY-MM-DD HH:MM:SS"
 *              ),
 *              @OA\Property(
 *                  property="ttotable_id",
 *                  type="integer",
 *                  format="int64",
 *                  description="Eeztable id property"
 *              ),
 *              @OA\Property(
 *                  property="ttotable_type",
 *                  type="string",
 *                  description="Eeztable type property"
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/UpdateElementRequest")
 *     }
 * )
 */
