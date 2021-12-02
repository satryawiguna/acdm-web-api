<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IAsrtEloquent extends IBaseEntity
{
    const TABLE_NAME = 'asrts';
    const MORPH_NAME = 'asrts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAsrt(): DateTime;

    public function setAsrt(DateTime $asrt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAsrtableId(): int;

    public function setAsrtableId(int $asrtable_id);

    public function getAsrtableType(): string;

    public function setAsrtableType(string $asrtable_type);

}
