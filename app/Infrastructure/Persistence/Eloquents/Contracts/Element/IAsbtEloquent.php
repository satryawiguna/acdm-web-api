<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAsbtEloquent extends IBaseEntity
{
    const TABLE_NAME = 'asbts';
    const MORPH_NAME = 'asbts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAsbt(): DateTime;

    public function setAsbt(DateTime $asbt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAsbtableId(): int;

    public function setAsbtableId(int $asbtable_id);

    public function getAsbtableType(): string;

    public function setAsbtableType(string $asbtable_type);
}
