<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAxotEloquent extends IBaseEntity
{
    const TABLE_NAME = 'axots';
    const MORPH_NAME = 'axots';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAxot(): int;

    public function setAxot(int $axot);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAxotableId(): int;

    public function setAxotableId(int $axotable_id);

    public function getAxotableType(): string;

    public function setAxotableType(string $axotable_type);

}
