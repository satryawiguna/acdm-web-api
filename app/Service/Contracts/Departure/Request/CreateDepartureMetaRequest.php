<?php


namespace App\Service\Contracts\Departure\Request;


use App\Core\Service\Request\AuditableRequest;

/**
 * @OA\Schema(
 *     schema="CreateDepartureMetaRequest",
 *     title="Create Departure Meta Request",
 *     description="Create departure meta request schema",
 *     required={"flight", "sobt", "eobt", "tobt", "aegt", "ardt", "aobt", "tsat", "ttot", "atot"}
 * )
 */
class CreateDepartureMetaRequest extends AuditableRequest
{
    /**
     * @OA\Property(
     *     property="flight",
     *     description="Flight property",
     *     type="object",
     *     example="{""priority"":{""icon"":null,""type"":null,""blink"":null},""tickmark"":{""icon"":null,""blink"":null,""color"":null},""acknowledge"":false}"
     * )
     */
    public object $flight;

    /**
     * @OA\Property(
     *     property="sobt",
     *     description="Sobt property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $sobt;

    /**
     * @OA\Property(
     *     property="eobt",
     *     description="Eobt property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $eobt;

    /**
     * @OA\Property(
     *     property="tobt",
     *     description="Tobt property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $tobt;

    /**
     * @OA\Property(
     *     property="aegt",
     *     description="Aegt property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $aegt;

    /**
     * @OA\Property(
     *     property="ardt",
     *     description="Ardt property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $ardt;

    /**
     * @OA\Property(
     *     property="aobt",
     *     description="Aobt property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $aobt;

    /**
     * @OA\Property(
     *     property="tsat",
     *     description="Tsat property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $tsat;

    /**
     * @OA\Property(
     *     property="ttot",
     *     description="Ttot property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $ttot;

    /**
     * @OA\Property(
     *     property="atot",
     *     description="Atot property",
     *     type="object",
     *     example="{""tickmark"":{""icon"":null,""blink"":null,""color"":null}}"
     * )
     */
    public object $atot;

    /**
     * @return object
     */
    public function getFlight(): object
    {
        return $this->flight;
    }

    /**
     * @param object $flight
     */
    public function setFlight(object $flight): void
    {
        $this->flight = $flight;
    }

    /**
     * @return object
     */
    public function getSobt(): object
    {
        return $this->sobt;
    }

    /**
     * @param object $sobt
     */
    public function setSobt(object $sobt): void
    {
        $this->sobt = $sobt;
    }

    /**
     * @return object
     */
    public function getEobt(): object
    {
        return $this->eobt;
    }

    /**
     * @param object $eobt
     */
    public function setEobt(object $eobt): void
    {
        $this->eobt = $eobt;
    }

    /**
     * @return object
     */
    public function getTobt(): object
    {
        return $this->tobt;
    }

    /**
     * @param object $tobt
     */
    public function setTobt(object $tobt): void
    {
        $this->tobt = $tobt;
    }

    /**
     * @return object
     */
    public function getAegt(): object
    {
        return $this->aegt;
    }

    /**
     * @param object $aegt
     */
    public function setAegt(object $aegt): void
    {
        $this->aegt = $aegt;
    }

    /**
     * @return object
     */
    public function getArdt(): object
    {
        return $this->ardt;
    }

    /**
     * @param object $ardt
     */
    public function setArdt(object $ardt): void
    {
        $this->ardt = $ardt;
    }

    /**
     * @return object
     */
    public function getAobt(): object
    {
        return $this->aobt;
    }

    /**
     * @param object $aobt
     */
    public function setAobt(object $aobt): void
    {
        $this->aobt = $aobt;
    }

    /**
     * @return object
     */
    public function getTsat(): object
    {
        return $this->tsat;
    }

    /**
     * @param object $tsat
     */
    public function setTsat(object $tsat): void
    {
        $this->tsat = $tsat;
    }

    /**
     * @return object
     */
    public function getTtot(): object
    {
        return $this->ttot;
    }

    /**
     * @param object $ttot
     */
    public function setTtot(object $ttot): void
    {
        $this->ttot = $ttot;
    }

    /**
     * @return object
     */
    public function getAtot(): object
    {
        return $this->atot;
    }

    /**
     * @param object $atot
     */
    public function setAtot(object $atot): void
    {
        $this->atot = $atot;
    }
}
