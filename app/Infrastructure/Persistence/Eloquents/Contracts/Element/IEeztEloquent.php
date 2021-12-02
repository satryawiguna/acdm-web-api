<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IEeztEloquent extends IBaseEntity
{
    const TABLE_NAME = 'eezts';
    const MORPH_NAME = 'eezts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getEezt(): DateTime;

    public function setEezt(DateTime $eezt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getEeztableId(): int;

    public function setEeztableId(int $eeztable_id);

    public function getEeztableType(): string;

    public function setEeztableType(string $eeztable_type);

}
