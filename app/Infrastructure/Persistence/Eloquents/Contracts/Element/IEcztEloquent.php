<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IEcztEloquent extends IBaseEntity
{
    const TABLE_NAME = 'eczts';
    const MORPH_NAME = 'eczts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getEczt(): DateTime;

    public function setEczt(DateTime $eczt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getEcztableId(): int;

    public function setEcztableId(int $ecztable_id);

    public function getEcztableType(): string;

    public function setEcztableType(string $ecztable_type);

}
