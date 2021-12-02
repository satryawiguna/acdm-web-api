<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IErztEloquent extends IBaseEntity
{
    const TABLE_NAME = 'erzts';
    const MORPH_NAME = 'erzts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getErzt(): DateTime;

    public function setErzt(DateTime $erzt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getErztableId(): int;

    public function setErztableId(int $erztable_id);

    public function getErztableType(): string;

    public function setErztableType(string $erztable_type);
}
