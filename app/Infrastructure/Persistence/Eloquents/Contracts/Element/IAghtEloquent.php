<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAghtEloquent extends IBaseEntity
{
    const TABLE_NAME = 'aghts';
    const MORPH_NAME = 'aghts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAght(): DateTime;

    public function setAght(DateTime $aght);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAghtableId(): int;

    public function setAghtableId(int $aghtable_id);

    public function getAghtableType(): string;

    public function setAghtableType(string $aghtable_type);
}
