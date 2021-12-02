<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IArztEloquent extends IBaseEntity
{
    const TABLE_NAME = 'arzts';
    const MORPH_NAME = 'arzts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getArzt(): DateTime;

    public function setArzt(DateTime $arzt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getArztableId(): int;

    public function setArztableId(int $arztable_id);

    public function getArztableType(): string;

    public function setArztableType(string $arztable_type);
}
