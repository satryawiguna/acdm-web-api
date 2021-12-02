<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use DateTime;
use Illuminate\Http\Request;

interface ITobtEloquent
{
    const TABLE_NAME = 'tobts';
    const MORPH_NAME = 'tobts';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getTobt(): DateTime;

    public function setTobt(DateTime $tobt);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getTobtableId(): int;

    public function setTobtableId(int $tobtable_id);

    public function getTobtableType(): string;

    public function setTobtableType(string $tobtable_type);
}
