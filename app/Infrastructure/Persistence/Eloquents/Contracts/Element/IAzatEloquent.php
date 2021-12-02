<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAzatEloquent extends IBaseEntity
{
    const TABLE_NAME = 'azats';
    const MORPH_NAME = 'azats';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAzat(): DateTime;

    public function setAzat(DateTime $azat);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAzatableId(): int;

    public function setAzatableId(int $azatable_id);

    public function getAzatableType(): string;

    public function setAzatableType(string $azatable_type);

}
