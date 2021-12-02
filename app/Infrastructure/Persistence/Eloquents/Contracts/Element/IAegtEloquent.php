<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAegtEloquent extends IBaseEntity
{
    const TABLE_NAME = 'aegts';
    const MORPH_NAME = 'aegts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAegt(): DateTime;

    public function setAegt(DateTime $aegt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAegtableId(): int;

    public function setAegtableId(int $aegtable_id);

    public function getAegtableType(): string;

    public function setAegtableType(string $aegtable_type);
}
