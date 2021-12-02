<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\MasterData;


use App\Core\Domain\Contracts\IBaseEntity;

interface IAirportEloquent extends IBaseEntity
{
    const TABLE_NAME = 'airports';
    const MORPH_NAME = 'airports';

    public function getName(): string;

    public function setName(string $name);

    public function getSlug(): string;

    public function setSlug(string $slug);

    public function getLocation(): string;

    public function setLocation(string $location);

    public function getCountry(): string;

    public function setCountry(string $country);

    public function getIcao(): string;

    public function setIcao(string $icao);

    public function getIata(): string;

    public function setIata(string $iata);
}
