<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAcgtEloquent extends IBaseEntity
{
    const TABLE_NAME = 'acgts';
    const MORPH_NAME = 'acgts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAcgt(): DateTime;

    public function setAcgt(DateTime $acgt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAcgtableId(): int;

    public function setAcgtableId(int $acgtable_id);

    public function getAcgtableType(): string;

    public function setAcgtableType(string $acgtable_type);
}
