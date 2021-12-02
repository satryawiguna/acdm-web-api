<?php


namespace App\Infrastructure\Persistence\Eloquents\Contracts\Departure;


use App\Core\Domain\Contracts\IBaseEntity;

interface IFlightInformationEloquent extends IBaseEntity
{
    const TABLE_NAME = 'flight_informations';
    const MORPH_NAME = 'flight_informations';

    public function getDepartureId(): int;

    public function setDepartureId(int $departure_id);

    public function getType(): string;

    public function setType(string $type);

    public function getReason(): string;

    public function setReason(string $reason);

    public function getRoleId(): int;

    public function setRoleId(int $role_id);
}
