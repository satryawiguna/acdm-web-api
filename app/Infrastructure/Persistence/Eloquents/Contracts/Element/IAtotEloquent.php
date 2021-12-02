<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAtotEloquent extends IBaseEntity
{
    const TABLE_NAME = 'atots';
    const MORPH_NAME = 'atots';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAtot(): DateTime;

    public function setAtot(DateTime $atot);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAtotableId(): int;

    public function setAtotableId(int $atotable_id);

    public function getAtotableType(): string;

    public function setAtotableType(string $atotable_type);

}
