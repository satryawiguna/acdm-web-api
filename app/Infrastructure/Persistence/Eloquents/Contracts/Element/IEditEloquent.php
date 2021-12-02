<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Element;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IEditEloquent extends IBaseEntity
{
    const TABLE_NAME = 'edits';
    const MORPH_NAME = 'edits';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getEdit(): int;

    public function setEdit(int $edit);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getInit(): bool;

    public function setInit(bool $init);

    public function getEditableId(): int;

    public function setEditableId(int $editable_id);

    public function getEditableType(): string;

    public function setEditableType(string $editable_type);
}
