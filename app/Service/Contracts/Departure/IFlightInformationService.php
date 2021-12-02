<?php


namespace App\Service\Contracts\Departure;


use App\Core\Service\Response\GenericObjectResponse;
use App\Service\Contracts\Departure\Request\CreateFlightInformationRequest;

interface IFlightInformationService
{
    public function getLatestFlightInformation(int $departureId): GenericObjectResponse;

    public function createFlightInformation(CreateFlightInformationRequest $request): GenericObjectResponse;
}
