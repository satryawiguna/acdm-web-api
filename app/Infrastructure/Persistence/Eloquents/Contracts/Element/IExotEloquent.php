<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IExotEloquent extends IBaseEntity
{
    const TABLE_NAME = 'exots';
    const MORPH_NAME = 'exots';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getExot(): int;

    public function setExot(int $exot);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getExotableId(): int;

    public function setExotableId(int $exotable_id);

    public function getExotableType(): string;

    public function setExotableType(string $exotable_type);
}
