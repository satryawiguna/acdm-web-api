<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface ITtotEloquent extends IBaseEntity
{
    const TABLE_NAME = 'ttots';
    const MORPH_NAME = 'ttots';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getTtot(): DateTime;

    public function setTtot(DateTime $ttot);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getTtotableId(): int;

    public function setTtotableId(int $ttotable_id);

    public function getTtotableType(): string;

    public function setTtotableType(string $ttotable_type);
}
