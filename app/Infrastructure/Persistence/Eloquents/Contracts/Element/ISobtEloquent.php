<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use DateTime;

interface ISobtEloquent
{
    const TABLE_NAME = 'sobts';
    const MORPH_NAME = 'sobts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getSobt(): DateTime;

    public function setSobt(DateTime $sobt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getSobtableId(): int;

    public function setSobtableId(int $sobtable_id);

    public function getSobtableType(): string;

    public function setSobtableType(string $sobtable_type);
}
