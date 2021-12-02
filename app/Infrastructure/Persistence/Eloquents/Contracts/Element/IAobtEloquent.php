<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use DateTime;

interface IAobtEloquent
{
    const TABLE_NAME = 'aobts';
    const MORPH_NAME = 'aobts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getAobt(): DateTime;

    public function setAobt(DateTime $ardt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getAobtableId(): int;

    public function setAobtableId(int $aobtable_id);

    public function getAobtableType(): string;

    public function setAobtableType(string $aobtable_type);
}
