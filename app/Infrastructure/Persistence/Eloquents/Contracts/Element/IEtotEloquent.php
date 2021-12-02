<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IEtotEloquent extends IBaseEntity
{
    const TABLE_NAME = 'etots';
    const MORPH_NAME = 'etots';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getEtot(): DateTime;

    public function setEtot(DateTime $etot);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getEtotableId(): int;

    public function setEtotableId(int $etotable_id);

    public function getEtotableType(): string;

    public function setEtotableType(string $etotable_type);
}
