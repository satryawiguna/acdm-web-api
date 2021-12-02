<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IStetEloquent extends IBaseEntity
{
    const TABLE_NAME = 'stets';
    const MORPH_NAME = 'stets';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getStet(): DateTime;

    public function setStet(DateTime $stet);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getStetableId(): int;

    public function setStetableId(int $stetable_id);

    public function getStetableType(): string;

    public function setStetableType(string $stetable_type);
}
