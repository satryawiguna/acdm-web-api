<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface ICtotEloquent extends IBaseEntity
{
    const TABLE_NAME = 'ctots';
    const MORPH_NAME = 'ctots';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getCtot(): DateTime;

    public function setCtot(DateTime $ctot);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getCtotableId(): int;

    public function setCtotableId(int $ctotable_id);

    public function getCtotableType(): string;

    public function setCtotableType(string $ctotable_type);

}
