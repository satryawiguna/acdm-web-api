<?php
namespace App\Infrastructure\Persistence\Eloquents\Contracts\Departure;


use App\Core\Domain\Contracts\IBaseEntity;
use DateTime;

interface IDepartureEloquent extends IBaseEntity
{
    const TABLE_NAME = 'departures';
    const MORPH_NAME = 'departures';

    public function getAodbId(): int;

    public function setAodbId(int $aodb_id);

    public function getAirportId(): int;

    public function setAirportId(int $airport_id);

    public function getAirlineId(): int;

    public function setAirlineId(int $airline_id);

    public function getFlightNumber(): string;

    public function setFlightNumber(string $flight_number);

    public function getFlightNumberableId(): int;

    public function setFlightNumberableId(int $flight_numberable_id);

    public function getFlightNumberableType(): string;

    public function setFlightNumberableType(string $flight_numberable_type);

    public function getCallSign(): string;

    public function setCallSign(string $call_sign);

    public function getNature(): string;

    public function setNature(string $nature);

    public function getNatureableId(): int;

    public function setNatureableId(int $natureable_id);

    public function getNatureableType(): string;

    public function setNatureableType(string $natureable_type);

    public function getAcft(): string;

    public function setAcft(string $acft);

    public function getAcftableId(): int;

    public function setAcftableId(int $acftable_id);

    public function getAcftableType(): string;

    public function setAcftableType(string $acftable_type);

    public function getRegister(): string;

    public function setRegister(string $register);

    public function getRegisterableId(): int;

    public function setRegisterableId(int $registerable_id);

    public function getRegisterableType(): string;

    public function setRegisterableType(string $registerable_type);

    public function getStand(): string;

    public function setStand(string $stand);

    public function getStandableId(): int;

    public function setStandableId(int $standable_id);

    public function getStandableType(): string;

    public function setStandableType(string $standable_type);

    public function getGateName(): string;

    public function setGateName(string $gate_name);

    public function getGateNameableId(): int;

    public function setGateNameableId(int $gate_nameable_id);

    public function getGateNameableType(): string;

    public function setGateNameableType(string $gate_nameable_type);

    public function getGateOpen(): DateTime;

    public function setGateOpen(DateTime $gate_open);

    public function getGateOpenableId(): int;

    public function setGateOpenableId(int $gate_openable_id);

    public function getGateOpenableType(): string;

    public function setGateOpenableType(string $gate_openable_type);

    public function getRunwayActual(): string;

    public function setRunwayActual(string $runway_actual);

    public function getRunwayActualableId(): int;

    public function setRunwayActualableId(int $runway_actualable_id);

    public function getRunwayActualableType(): string;

    public function setRunwayActualableType(string $runway_actualable_type);

    public function getRunwayEstimated(): string;

    public function setRunwayEstimated(string $runway_estimated);

    public function getRunwayEstimatedableId(): int;

    public function setRunwayEstimatedableId(int $runway_estimatedable_id);

    public function getRunwayEstimatedableType(): string;

    public function setRunwayEstimatedableType(string $runway_estimatedable_type);

    public function getTransit(): string;

    public function setTransit(string $transit);

    public function getTransitableId(): int;

    public function setTransitableId(int $transitable_id);

    public function getTransitableType(): string;

    public function setTransitableType(string $transitable_type);

    public function getDestination(): string;

    public function setDestination(string $destination);

    public function getDestinationableId(): int;

    public function setDestinationableId(int $destinationable_id);

    public function getDestinationableType(): string;

    public function setDestinationableType(string $destinationable_type);

    public function getStatus(): string;

    public function setStatus(string $status);

    public function getCodeShare(): string;

    public function setCodeShare(string $code_share);

    public function getDataOrigin(): string;

    public function setDataOrigin(string $data_origin);

    public function getDataOriginableId(): int;

    public function setDataOriginableId(int $data_originable_id);

    public function getDataOriginableType(): string;

    public function setDataOriginableType(string $data_originable_type);
}
