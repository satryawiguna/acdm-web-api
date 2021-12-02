<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAeztEloquent extends IBaseEntity
{
    const TABLE_NAME = 'aezts';
    const MORPH_NAME = 'aezts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAezt(): DateTime;

    public function setAezt(DateTime $aezt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAeztableId(): int;

    public function setAeztableId(int $aeztable_id);

    public function getAeztableType(): string;

    public function setAeztableType(string $aeztable_type);
}
