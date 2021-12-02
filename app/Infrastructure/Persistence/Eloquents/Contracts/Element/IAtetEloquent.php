<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAtetEloquent extends IBaseEntity
{
    const TABLE_NAME = 'atets';
    const MORPH_NAME = 'atets';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAtet(): DateTime;

    public function setAtet(DateTime $atet);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAtetableId(): int;

    public function setAtetableId(int $atetable_id);

    public function getAtetableType(): string;

    public function setAtetableType(string $atetable_type);

}
