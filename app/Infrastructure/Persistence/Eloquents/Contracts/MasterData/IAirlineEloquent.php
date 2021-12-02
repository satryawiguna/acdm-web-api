<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\MasterData;


use App\Core\Domain\Contracts\IBaseEntity;

interface IAirlineEloquent extends IBaseEntity
{
    const TABLE_NAME = 'airlines';
    const MORPH_NAME = 'airlines';

    public function getFlightNumber(): string;

    public function setFlightNumber(string $flight_number);

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getIcao(): string;

    public function setIcao(string $icao);

    public function getIata(): string;

    public function setIata(string $iata);

    public function getCallSign(): string;

    public function setCallSign(string $call_sign);
}
