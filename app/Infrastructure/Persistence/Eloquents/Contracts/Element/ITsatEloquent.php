<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface ITsatEloquent extends IBaseEntity
{
    const TABLE_NAME = 'tsats';
    const MORPH_NAME = 'tsats';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getTsat(): DateTime;

    public function setTsat(DateTime $tsat);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getTsatableId(): int;

    public function setTsatableId(int $tsatable_id);

    public function getTsatableType(): string;

    public function setTsatableType(string $tsatable_type);
}
