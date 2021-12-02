<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Departure;


use App\Core\Domain\Contracts\IBaseEntity;

interface IDepartureMetaEloquent extends IBaseEntity
{
    const TABLE_NAME = 'departure_metas';
    const MORPH_NAME = 'departure_metas';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getFlight(): object;

    public function setFlight(object $airport_id);

    public function getSobt(): object;

    public function setSobt(object $sobt);

    public function getEobt(): object;

    public function setEobt(object $eobt);

    public function getTobt(): object;

    public function setTobt(object $tobt);

    public function getAegt(): object;

    public function setAegt(object $aegt);

    public function getArdt(): object;

    public function setArdt(object $ardt);

    public function getTsat(): object;

    public function setTsat(object $tsat);

    public function getAobt(): object;

    public function setAobt(object $aobt);

    public function getTtot(): object;

    public function setTtot(object $ttot);

    public function getAtot(): object;

    public function setAtot(object $atot);

}
