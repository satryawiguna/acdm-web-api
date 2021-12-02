<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IStstEloquent extends IBaseEntity
{
    const TABLE_NAME = 'ststs';
    const MORPH_NAME = 'ststs';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getStst(): DateTime;

    public function setStst(DateTime $stst);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getStstableId(): int;

    public function setStstableId(int $ststable_id);

    public function getStstableType(): string;

    public function setStstableType(string $ststable_type);

}
