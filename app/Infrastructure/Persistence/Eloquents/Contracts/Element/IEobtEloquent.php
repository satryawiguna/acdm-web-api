<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IEobtEloquent extends IBaseEntity
{
    const TABLE_NAME = 'eobts';
    const MORPH_NAME = 'eobts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getEobt(): DateTime;

    public function setEobt(DateTime $eobt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getEobtableId(): int;

    public function setEobtableId(int $eobtable_id);

    public function getEobtableType(): string;

    public function setEobtableType(string $eobtable_type);
}
