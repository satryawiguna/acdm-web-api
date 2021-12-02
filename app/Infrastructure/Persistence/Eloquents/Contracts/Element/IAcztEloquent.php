<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAcztEloquent extends IBaseEntity
{
    const TABLE_NAME = 'aczts';
    const MORPH_NAME = 'aczts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAczt(): DateTime;

    public function setAczt(DateTime $aczt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAcztableId(): int;

    public function setAcztableId(int $acztable_id);

    public function getAcztableType(): string;

    public function setAcztableType(string $acztable_type);
}
