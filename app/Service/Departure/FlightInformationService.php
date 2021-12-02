<?php


namespace App\Service\Departure;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Response\GenericObjectResponse;
use App\Domain\Contracts\Depature\IFlightInformationRepository;
use App\Service\BaseService;
use App\Service\Contracts\Departure\IFlightInformationService;
use App\Service\Contracts\Departure\Request\CreateFlightInformationRequest;

class FlightInformationService extends BaseService implements IFlightInformationService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IFlightInformationRepository $_flightInformationRepository;

    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IFlightInformationRepository $flightInformationRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;

        $this->_flightInformationRepository = $flightInformationRepository;
    }

    public function getLatestFlightInformation(int $departureId): GenericObjectResponse
    {
        return $this->read(
            [$this->_flightInformationRepository, 'findLatestFlightInformationByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createFlightInformation(CreateFlightInformationRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $flightInformation = $this->_flightInformationRepository->newInstance([
                "departure_id" => $request->departure_id,
                "type" => $request->type,
                "reason" => $request->reason,
                "role_id" => $request->role_id
            ]);

            $this->setAuditableInformationFromRequest($flightInformation, $request);

            $rules = [
                'departure_id' => 'required',
                'type' => 'required',
                'role_id' => 'required'
            ];

            $brokenRules = $flightInformation->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $flightInformationResult = $unitOfWork->markNewAndSaveChange($this->_flightInformationRepository, $flightInformation);

            $response->dto = $flightInformationResult;
            $response->addInfoMessageResponse('Flight information created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
