<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use DateTime;

interface IArdtEloquent
{
    const TABLE_NAME = 'ardts';
    const MORPH_NAME = 'ardts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getArdt(): DateTime;

    public function setArdt(DateTime $ardt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getArdtableId(): int;

    public function setArdtableId(int $ardtable_id);

    public function getArdtableType(): string;

    public function setArdtableType(string $ardtable_type);
}
