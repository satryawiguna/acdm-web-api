<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAtstEloquent extends IBaseEntity
{
    const TABLE_NAME = 'atsts';
    const MORPH_NAME = 'atsts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAtst(): DateTime;

    public function setAtst(DateTime $atst);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAtstableId(): int;

    public function setAtstableId(int $atstable_id);

    public function getAtstableType(): string;

    public function setAtstableType(string $atstable_type);

}
