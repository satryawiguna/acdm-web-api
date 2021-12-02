<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAtttEloquent extends IBaseEntity
{
    const TABLE_NAME = 'attts';
    const MORPH_NAME = 'attts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAttt(): int;

    public function setAttt(int $attt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAtttableId(): int;

    public function setAtttableId(int $atttable_id);

    public function getAtttableType(): string;

    public function setAtttableType(string $atttable_type);
}
