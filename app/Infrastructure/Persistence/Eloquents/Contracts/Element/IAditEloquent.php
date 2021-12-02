<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAditEloquent extends IBaseEntity
{
    const TABLE_NAME = 'adits';
    const MORPH_NAME = 'adits';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAdit(): int;

    public function setAdit(int $adit);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAditableId(): int;

    public function setAditableId(int $aditable_id);

    public function getAditableType(): string;

    public function setAditableType(string $aditable_type);
}
