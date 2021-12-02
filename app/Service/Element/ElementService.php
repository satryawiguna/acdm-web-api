<?php
namespace App\Service\Element;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Domain\Contracts\Element\IAcgtRepository;
use App\Domain\Contracts\Element\IAcztRepository;
use App\Domain\Contracts\Element\IAditRepository;
use App\Domain\Contracts\Element\IAegtRepository;
use App\Domain\Contracts\Element\IAeztRepository;
use App\Domain\Contracts\Element\IAghtRepository;
use App\Domain\Contracts\Element\IAobtRepository;
use App\Domain\Contracts\Element\IArdtRepository;
use App\Domain\Contracts\Element\IArztRepository;
use App\Domain\Contracts\Element\IAsbtRepository;
use App\Domain\Contracts\Element\IAsrtRepository;
use App\Domain\Contracts\Element\IAtetRepository;
use App\Domain\Contracts\Element\IAtotRepository;
use App\Domain\Contracts\Element\IAtstRepository;
use App\Domain\Contracts\Element\IAtttRepository;
use App\Domain\Contracts\Element\IAxotRepository;
use App\Domain\Contracts\Element\IAzatRepository;
use App\Domain\Contracts\Element\ICtotRepository;
use App\Domain\Contracts\Element\IEcztRepository;
use App\Domain\Contracts\Element\IEditRepository;
use App\Domain\Contracts\Element\IEeztRepository;
use App\Domain\Contracts\Element\IEobtRepository;
use App\Domain\Contracts\Element\IErztRepository;
use App\Domain\Contracts\Element\IEtotRepository;
use App\Domain\Contracts\Element\IExotRepository;
use App\Domain\Contracts\Element\ISobtRepository;
use App\Domain\Contracts\Element\IStetRepository;
use App\Domain\Contracts\Element\IStstRepository;
use App\Domain\Contracts\Element\ITobtRepository;
use App\Domain\Contracts\Element\ITsatRepository;
use App\Domain\Contracts\Element\ITtotRepository;
use App\Help\Domain\Timezone;
use App\Service\BaseService;
use App\Service\Contracts\Element\IElementService;
use App\Service\Contracts\Element\Request\CreateElementRequest;
use Illuminate\Support\Facades\Config;

class ElementService extends BaseService implements IElementService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IAcgtRepository $_acgtRepository;
    private IAcztRepository $_acztRepository;
    private IAditRepository $_aditRepository;
    private IAegtRepository $_aegtRepository;
    private IAeztRepository $_aeztRepository;
    private IAghtRepository $_aghtRepository;
    private IAobtRepository $_aobtRepository;
    private IArdtRepository $_ardtRepository;
    private IArztRepository $_arztRepository;
    private IAsbtRepository $_asbtRepository;
    private IAsrtRepository $_asrtRepository;
    private IAtetRepository $_atetRepository;
    private IAtotRepository $_atotRepository;
    private IAtstRepository $_atstRepository;
    private IAtttRepository $_atttRepository;
    private IAxotRepository $_axotRepository;
    private IAzatRepository $_azatRepository;
    private ICtotRepository $_ctotRepository;
    private IEcztRepository $_ecztRepository;
    private IEditRepository $_editRepository;
    private IEeztRepository $_eeztRepository;
    private IEobtRepository $_eobtRepository;
    private IErztRepository $_erztRepository;
    private IEtotRepository $_etotRepository;
    private IExotRepository $_exotRepository;
    private ISobtRepository $_sobtRepository;
    private IStetRepository $_stetRepository;
    private IStstRepository $_ststRepository;
    private ITobtRepository $_tobtRepository;
    private ITsatRepository $_tsatRepository;
    private ITtotRepository $_ttotRepository;

    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IAcgtRepository $acgtRepository, IAcztRepository $acztRepository, IAditRepository $aditRepository,
                                IAegtRepository $aegtRepository, IAeztRepository $aeztRepository, IAghtRepository $aghtRepository,
                                IAobtRepository $aobtRepository, IArdtRepository $ardtRepository, IArztRepository $arztRepository,
                                IAsbtRepository $asbtRepository, IAsrtRepository $asrtRepository, IAtetRepository $atetRepository,
                                IAtotRepository $atotRepository, IAtstRepository $atstRepository, IAtttRepository $atttRepository,
                                IAxotRepository $axotRepository, IAzatRepository $azatRepository, ICtotRepository $ctotRepository,
                                IEcztRepository $ecztRepository, IEditRepository $editRepository, IEeztRepository $eeztRepository,
                                IEobtRepository $eobtRepository, IErztRepository $erztRepository, IEtotRepository $etotRepository,
                                IExotRepository $exotRepository, ISobtRepository $sobtRepository, IStetRepository $stetRepository,
                                IStstRepository $ststRepository, ITobtRepository $tobtRepository, ITsatRepository $tsatRepository,
                                ITtotRepository $ttotRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;

        $this->_acgtRepository = $acgtRepository;
        $this->_acztRepository = $acztRepository;
        $this->_aditRepository = $aditRepository;
        $this->_aegtRepository = $aegtRepository;
        $this->_aeztRepository = $aeztRepository;
        $this->_aghtRepository = $aghtRepository;
        $this->_aobtRepository = $aobtRepository;
        $this->_ardtRepository = $ardtRepository;
        $this->_arztRepository = $arztRepository;
        $this->_asbtRepository = $asbtRepository;
        $this->_asrtRepository = $asrtRepository;
        $this->_atetRepository = $atetRepository;
        $this->_atotRepository = $atotRepository;
        $this->_atstRepository = $atstRepository;
        $this->_atttRepository = $atttRepository;
        $this->_axotRepository = $axotRepository;
        $this->_azatRepository = $azatRepository;
        $this->_ctotRepository = $ctotRepository;
        $this->_ecztRepository = $ecztRepository;
        $this->_editRepository = $editRepository;
        $this->_eeztRepository = $eeztRepository;
        $this->_eobtRepository = $eobtRepository;
        $this->_erztRepository = $erztRepository;
        $this->_etotRepository = $etotRepository;
        $this->_exotRepository = $exotRepository;
        $this->_sobtRepository = $sobtRepository;
        $this->_stetRepository = $stetRepository;
        $this->_ststRepository = $ststRepository;
        $this->_tobtRepository = $tobtRepository;
        $this->_tsatRepository = $tsatRepository;
        $this->_ttotRepository = $ttotRepository;
    }

    public function getAcgts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_acgtRepository, 'findAcgtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAcgt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $acgt = $this->_acgtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "acgtable_id" => $request->acgtable_id,
                "acgtable_type" => $request->acgtable_type
            ]);

            $acgt->setAcgt($request->acgt);

            $this->setAuditableInformationFromRequest($acgt, $request);

            $rules = [
                'departure_id' => 'required',
                'acgt' => 'required',
                'acgtable_id' => 'required',
                'acgtable_type' => 'required',
            ];

            $brokenRules = $acgt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $acgtResult = $unitOfWork->markNewAndSaveChange($this->_acgtRepository, $acgt);

            $response->dto = $acgtResult;
            $response->addInfoMessageResponse('ACGT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAczts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_acztRepository, 'findAcztByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAczt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $aczt = $this->_acgtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "acztable_id" => $request->acztable_id,
                "acztable_type" => $request->acztable_type
            ]);

            $aczt->setAczt($request->aczt);

            $this->setAuditableInformationFromRequest($aczt, $request);

            $rules = [
                'departure_id' => 'required',
                'aczt' => 'required',
                'acztable_id' => 'required',
                'acztable_type' => 'required'
            ];

            $brokenRules = $aczt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $acztResult = $unitOfWork->markNewAndSaveChange($this->_acztRepository, $aczt);

            $response->dto = $acztResult;
            $response->addInfoMessageResponse('ACZT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAdits(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aditRepository, 'findAditByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAdit(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $adit = $this->_aditRepository->newInstance([
                "departure_id" => $request->departure_id,
                "adit" => $request->adit,
                "reason" => $request->reason,
                "aditable_id" => $request->aditable_id,
                "aditable_type" => $request->aditable_type
            ]);

            $this->setAuditableInformationFromRequest($adit, $request);

            $rules = [
                'departure_id' => 'required',
                'adit' => 'required',
                'aditable_id' => 'required',
                'aditable_type' => 'required'
            ];

            $brokenRules = $adit->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $aditResult = $unitOfWork->markNewAndSaveChange($this->_aditRepository, $adit);

            $response->dto = $aditResult;
            $response->addInfoMessageResponse('ADIT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAegts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aegtRepository, 'findAegtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAegt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $aegt = $this->_aegtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "aegtable_id" => $request->aegtable_id,
                "aegtable_type" => $request->aegtable_type
            ]);

            $aegt->setAegt($request->aegt);

            $this->setAuditableInformationFromRequest($aegt, $request);

            $rules = [
                'departure_id' => 'required',
                'aegt' => 'required',
                'aegtable_id' => 'required',
                'aegtable_type' => 'aegtable_type'
            ];

            $brokenRules = $aegt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $aegtResult = $unitOfWork->markNewAndSaveChange($this->_aegtRepository, $aegt);

            $response->dto = $aegtResult;
            $response->addInfoMessageResponse('AEGT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAezts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aeztRepository, 'findAeztByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAezt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $aezt = $this->_aeztRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "aeztable_id" => $request->aeztable_id,
                "aeztable_type" => $request->aeztable_type
            ]);

            $aezt->setAezt($request->aezt);

            $this->setAuditableInformationFromRequest($aezt, $request);

            $rules = [
                'departure_id' => 'required',
                'aezt' => 'required',
                'aeztable_id' => 'required',
                'aeztable_type' => 'required'
            ];

            $brokenRules = $aezt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $aeztResult = $unitOfWork->markNewAndSaveChange($this->_aeztRepository, $aezt);

            $response->dto = $aeztResult;
            $response->addInfoMessageResponse('AEZT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAghts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aghtRepository, 'findAghtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAght(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $aght = $this->_aeztRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "aghtable_id" => $request->aghtable_id,
                "aghtable_type" => $request->aghtable_type,
            ]);

            $aght->setAght($request->aght);

            $this->setAuditableInformationFromRequest($aght, $request);

            $rules = [
                'departure_id' => 'required',
                'aght' => 'required',
                'aghtable_id' => 'required',
                'aghtable_type' => 'required'
            ];

            $brokenRules = $aght->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $aghtResult = $unitOfWork->markNewAndSaveChange($this->_aghtRepository, $aght);

            $response->dto = $aghtResult;
            $response->addInfoMessageResponse('AGHT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAobts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aobtRepository, 'findAobtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAobt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $aobt = $this->_aobtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "aobtable_id" => $request->aobtable_id,
                "aobtable_type" => $request->aobtable_type
            ]);

            $aobt->setAobt($request->aobt);

            $this->setAuditableInformationFromRequest($aobt, $request);

            $rules = [
                'departure_id' => 'required',
                'aobt' => 'required',
                'aobtable_id' => 'required',
                'aobtable_type' => 'required'
            ];

            $brokenRules = $aobt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $aobtResult = $unitOfWork->markNewAndSaveChange($this->_aobtRepository, $aobt);

            $response->dto = $aobtResult;
            $response->addInfoMessageResponse('AOBT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getArdts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aditRepository, 'findArdtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createArdt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $ardt = $this->_ardtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "ardtable_id" => $request->ardtable_id,
                "ardtable_type" => $request->ardtable_type
            ]);

            $ardt->setArdt($request->ardt);

            $this->setAuditableInformationFromRequest($ardt, $request);

            $rules = [
                'departure_id' => 'required',
                'ardt' => 'required',
                'ardtable_id' => 'required',
                'ardtable_type' => 'required'
            ];

            $brokenRules = $ardt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $ardtResult = $unitOfWork->markNewAndSaveChange($this->_ardtRepository, $ardt);

            $response->dto = $ardtResult;
            $response->addInfoMessageResponse('ARDT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getArzts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_arztRepository, 'findArztByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createArzt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $arzt = $this->_arztRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "arztable_id" => $request->arztable_id,
                "arztable_type" => $request->arztable_type
            ]);

            $arzt->setArzt($request->arzt);

            $this->setAuditableInformationFromRequest($arzt, $request);

            $rules = [
                'departure_id' => 'required',
                'arzt' => 'required',
                'arztable_id' => 'required',
                'arztable_type' => 'required'
            ];

            $brokenRules = $arzt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $arztResult = $unitOfWork->markNewAndSaveChange($this->_arztRepository, $arzt);

            $response->dto = $arztResult;
            $response->addInfoMessageResponse('ARZT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAsbts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aditRepository, 'findAsbtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAsbt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $asbt = $this->_asbtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "asbtable_id" => $request->asbtable_id,
                "asbtable_type" => $request->asbtable_type
            ]);

            $asbt->setAsbt($request->asbt);

            $this->setAuditableInformationFromRequest($asbt, $request);

            $rules = [
                'departure_id' => 'required',
                'asbt' => 'required',
                'asbtable_id' => 'required',
                'asbtable_type' => 'required'
            ];

            $brokenRules = $asbt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $asbtResult = $unitOfWork->markNewAndSaveChange($this->_asbtRepository, $asbt);

            $response->dto = $asbtResult;
            $response->addInfoMessageResponse('ASBT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAsrts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_aditRepository, 'findAsrtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAsrt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $asrt = $this->_asrtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "asrtable_id" => $request->asrtable_id,
                "asrtable_type" => $request->asrtable_type
            ]);

            $asrt->setAsrt($request->asrt);

            $this->setAuditableInformationFromRequest($asrt, $request);

            $rules = [
                'departure_id' => 'required',
                'asrt' => 'required',
                'asrtable_id' => 'required',
                'asrtable_type' => 'required'
            ];

            $brokenRules = $asrt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $asrtResult = $unitOfWork->markNewAndSaveChange($this->_asrtRepository, $asrt);

            $response->dto = $asrtResult;
            $response->addInfoMessageResponse('ASRT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAtets(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_atetRepository, 'findAtetByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAtet(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $atet = $this->_atetRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "atetable_id" => $request->atetable_id,
                "atetable_type" => $request->atetable_type
            ]);

            $atet->setAtet($request->atet);

            $this->setAuditableInformationFromRequest($atet, $request);

            $rules = [
                'departure_id' => 'required',
                'atet' => 'required',
                'atetable_id' => 'required',
                'atetable_type' => 'required'
            ];

            $brokenRules = $atet->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $atetResult = $unitOfWork->markNewAndSaveChange($this->_atetRepository, $atet);

            $response->dto = $atetResult;
            $response->addInfoMessageResponse('ATET created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAtots(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_atotRepository, 'findAtotByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAtot(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $atot = $this->_atotRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "atotable_id" => $request->atotable_id,
                "atotable_type" => $request->atotable_type
            ]);

            $atot->setAtot($request->atot);

            $this->setAuditableInformationFromRequest($atot, $request);

            $rules = [
                'departure_id' => 'required',
                'atot' => 'required',
                'atotable_id' => 'required',
                'atotable_type' => 'required'
            ];

            $brokenRules = $atot->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $atotResult = $unitOfWork->markNewAndSaveChange($this->_atotRepository, $atot);

            $response->dto = $atotResult;
            $response->addInfoMessageResponse('ATOT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAtsts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_atstRepository, 'findAtstByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAtst(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $atst = $this->_atstRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "atstable_id" => $request->atstable_id,
                "atstable_type" => $request->atstable_type
            ]);

            $atst->setAtst($request->atst);

            $this->setAuditableInformationFromRequest($atst, $request);

            $rules = [
                'departure_id' => 'required',
                'atst' => 'required',
                'atstable_id' => 'required',
                'atstable_type' => 'required'
            ];

            $brokenRules = $atst->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $atstResult = $unitOfWork->markNewAndSaveChange($this->_atstRepository, $atst);

            $response->dto = $atstResult;
            $response->addInfoMessageResponse('ATST created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAttts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_atttRepository, 'findAtttByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAttt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $attt = $this->_atttRepository->newInstance([
                "departure_id" => $request->departure_id,
                "attt" => $request->attt,
                "reason" => $request->reason,
                "atttable_id" => $request->atttable_id,
                "atttable_type" => $request->atttable_type
            ]);

            $this->setAuditableInformationFromRequest($attt, $request);

            $rules = [
                'departure_id' => 'required',
                'attt' => 'required',
                'atttable_id' => 'required',
                'atttable_type' => 'required'
            ];

            $brokenRules = $attt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $atttResult = $unitOfWork->markNewAndSaveChange($this->_atttRepository, $attt);

            $response->dto = $atttResult;
            $response->addInfoMessageResponse('ATTT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAxots(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_axotRepository, 'findAxotByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAxot(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $axot = $this->_axotRepository->newInstance([
                "departure_id" => $request->departure_id,
                "axot" => $request->axot,
                "reason" => $request->reason,
                "axotable_id" => $request->axotable_id,
                "axotable_type" => $request->axotable_type
            ]);

            $this->setAuditableInformationFromRequest($axot, $request);

            $rules = [
                'departure_id' => 'required',
                'axot' => 'required',
                'axotable_id' => 'required',
                'axotable_type' => 'required'
            ];

            $brokenRules = $axot->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $axotResult = $unitOfWork->markNewAndSaveChange($this->_axotRepository, $axot);

            $response->dto = $axotResult;
            $response->addInfoMessageResponse('AXOT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getAzats(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_azatRepository, 'findAzatByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createAzat(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $azat = $this->_azatRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "azatable_id" => $request->azatable_id,
                "azatable_type" => $request->azatable_type
            ]);

            $azat->setAzat($request->azat);

            $this->setAuditableInformationFromRequest($azat, $request);

            $rules = [
                'departure_id' => 'required',
                'azat' => 'required',
                'azatable_id' => 'required',
                'azatable_type' => 'required'
            ];

            $brokenRules = $azat->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $azatResult = $unitOfWork->markNewAndSaveChange($this->_azatRepository, $azat);

            $response->dto = $azatResult;
            $response->addInfoMessageResponse('AZAT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getCtots(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_ctotRepository, 'findCtotByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createCtot(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $ctot = $this->_ctotRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "ctotable_id" => $request->ctotable_id,
                "ctotable_type" => $request->ctotable_type
            ]);

            $ctot->setCtot($request->ctot);

            $this->setAuditableInformationFromRequest($ctot, $request);

            $rules = [
                'departure_id' => 'required',
                'ctot' => 'required',
                'ctotable_id' => 'required',
                'ctotable_type' => 'required'
            ];

            $brokenRules = $ctot->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $ctotResult = $unitOfWork->markNewAndSaveChange($this->_ctotRepository, $ctot);

            $response->dto = $ctotResult;
            $response->addInfoMessageResponse('CTOT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getEczts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_ecztRepository, 'findEcztByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createEczt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $eczt = $this->_ecztRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "ecztable_id" => $request->ecztable_id,
                "ecztable_type" => $request->ecztable_type
            ]);

            $eczt->setEczt($request->eczt);

            $this->setAuditableInformationFromRequest($eczt, $request);

            $rules = [
                'departure_id' => 'required',
                'eczt' => 'required',
                'ecztable_id' => 'required',
                'ecztable_type' => 'required'
            ];

            $brokenRules = $eczt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $ecztResult = $unitOfWork->markNewAndSaveChange($this->_ecztRepository, $eczt);

            $response->dto = $ecztResult;
            $response->addInfoMessageResponse('ECZT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getEdits(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_editRepository, 'findEditByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createEdit(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $edit = $this->_editRepository->newInstance([
                "departure_id" => $request->departure_id,
                "edit" => $request->edit,
                "reason" => $request->reason,
                "editable_id" => $request->editable_id,
                "editable_type" => $request->editable_type
            ]);

            $this->setAuditableInformationFromRequest($edit, $request);

            $rules = [
                'departure_id' => 'required',
                'edit' => 'required',
                'editable_id' => 'required',
                'editable_type' => 'required'
            ];

            $brokenRules = $edit->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $editResult = $unitOfWork->markNewAndSaveChange($this->_editRepository, $edit);

            $response->dto = $editResult;
            $response->addInfoMessageResponse('EDIT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getEezts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_eeztRepository, 'findEeztByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createEezt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $eezt = $this->_eeztRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "eeztable_id" => $request->eeztable_id,
                "eeztable_type" => $request->eeztable_type
            ]);

            $eezt->setEezt($request->eezt);

            $this->setAuditableInformationFromRequest($eezt, $request);

            $rules = [
                'departure_id' => 'required',
                'eezt' => 'required',
                'eeztable_id' => 'required',
                'eeztable_type' => 'required'
            ];

            $brokenRules = $eezt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $eeztResult = $unitOfWork->markNewAndSaveChange($this->_eeztRepository, $eezt);

            $response->dto = $eeztResult;
            $response->addInfoMessageResponse('EEZT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getEobts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_eobtRepository, 'findEobtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createEobt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $eobt = $this->_eobtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "eobtable_id" => $request->eobtable_id,
                "eobtable_type" => $request->eobtable_type
            ]);

            $eobt->setEobt($request->eobt);

            $this->setAuditableInformationFromRequest($eobt, $request);

            $rules = [
                'departure_id' => 'required',
                'eobt' => 'required',
                'eobtable_id' => 'required',
                'eobtable_type' => 'required'
            ];

            $brokenRules = $eobt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $eobtResult = $unitOfWork->markNewAndSaveChange($this->_eeztRepository, $eobt);

            $response->dto = $eobtResult;
            $response->addInfoMessageResponse('EOBT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getErzts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_erztRepository, 'findErztByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createErzt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $erzt = $this->_eobtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "erztable_id" => $request->erztable_id,
                "erztable_type" => $request->erztable_type
            ]);

            $erzt->setErzt($request->erzt);

            $this->setAuditableInformationFromRequest($erzt, $request);

            $rules = [
                'departure_id' => 'required',
                'erzt' => 'required',
                'erztable_id' => 'required',
                'erztable_type' => 'required'
            ];

            $brokenRules = $erzt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $erztResult = $unitOfWork->markNewAndSaveChange($this->_eeztRepository, $erzt);

            $response->dto = $erztResult;
            $response->addInfoMessageResponse('ERZT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getEtots(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_etotRepository, 'findEtotByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createEtot(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $etot = $this->_etotRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "etotable_id" => $request->etotable_id,
                "etotable_type" => $request->etotable_type
            ]);

            $etot->setEtot($request->etot);

            $this->setAuditableInformationFromRequest($etot, $request);

            $rules = [
                'departure_id' => 'required',
                'etot' => 'required',
                'role_id' => 'required',
                'role_type' => 'required'
            ];

            $brokenRules = $etot->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $etotResult = $unitOfWork->markNewAndSaveChange($this->_etotRepository, $etot);

            $response->dto = $etotResult;
            $response->addInfoMessageResponse('ETOT created');

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getExots(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_exotRepository, 'findExotByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createExot(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $exot = $this->_exotRepository->newInstance([
                "departure_id" => $request->departure_id,
                "exot" => $request->exot,
                "reason" => $request->reason,
                "exotable_id" => $request->exotable_id,
                "exotable_type" => $request->exotable_type
            ]);

            $this->setAuditableInformationFromRequest($exot, $request);

            $rules = [
                'departure_id' => 'required',
                'exot' => 'required',
                'exotable_id' => 'required',
                'exotable_type' => 'required'
            ];

            $brokenRules = $exot->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $exotResult = $unitOfWork->markNewAndSaveChange($this->_exotRepository, $exot);

            $response->dto = $exotResult;
            $response->addInfoMessageResponse('EXOT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getSobts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_sobtRepository, 'findSobtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createSobt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $sobt = $this->_sobtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "sobtable_id" => $request->sobtable_id,
                "sobtable_type" => $request->sobtable_type
            ]);

            $sobt->setSobt($request->sobt);

            $this->setAuditableInformationFromRequest($sobt, $request);

            $rules = [
                'departure_id' => 'required',
                'sobt' => 'required',
                'sobtable_id' => 'required',
                'sobtable_type' => 'required'
            ];

            $brokenRules = $sobt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $sobtResult = $unitOfWork->markNewAndSaveChange($this->_sobtRepository, $sobt);

            $response->dto = $sobtResult;
            $response->addInfoMessageResponse('SOBT created');

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getStets(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_stetRepository, 'findStetByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createStet(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $stet = $this->_stetRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "stetable_id" => $request->stetable_id,
                "stetable_type" => $request->stetable_type
            ]);

            $stet->setStet($request->stet);

            $this->setAuditableInformationFromRequest($stet, $request);

            $rules = [
                'departure_id' => 'required',
                'stet' => 'required',
                'stetable_id' => 'required',
                'stetable_type' => 'required'
            ];

            $brokenRules = $stet->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $stetResult = $unitOfWork->markNewAndSaveChange($this->_stetRepository, $stet);

            $response->dto = $stetResult;
            $response->addInfoMessageResponse('STET created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getStsts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_ststRepository, 'findStstByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createStst(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $stst = $this->_ststRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "ststable_id" => $request->ststable_id,
                "ststable_type" => $request->ststable_type
            ]);

            $stst->setStst($request->stst);

            $this->setAuditableInformationFromRequest($stst, $request);

            $rules = [
                'departure_id' => 'required',
                'stst' => 'required',
                'ststable_id' => 'required',
                'ststable_type' => 'required'
            ];

            $brokenRules = $stst->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $ststResult = $unitOfWork->markNewAndSaveChange($this->_ststRepository, $stst);

            $response->dto = $ststResult;
            $response->addInfoMessageResponse('STST created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getTobts(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_tobtRepository, 'findTobtByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createTobt(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $tobt = $this->_tobtRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "tobtable_id" => $request->tobtable_id,
                "tobtable_type" => $request->tobtable_type,
            ]);

            $tobt->setTobt($request->tobt);

            $this->setAuditableInformationFromRequest($tobt, $request);

            $rules = [
                'departure_id' => 'required',
                'tobt' => 'required',
                'tobtable_id' => 'required',
                'tobtable_type' => 'required'
            ];

            $brokenRules = $tobt->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $tobtResult = $unitOfWork->markNewAndSaveChange($this->_tobtRepository, $tobt);

            $response->dto = $tobtResult;
            $response->addInfoMessageResponse('TOBT created');

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function showTobt(int $id, array $columns = ['*']): GenericObjectResponse
    {
        return $this->read(
            [$this->_tobtRepository, 'findTobt'],
            ['id' => $id, 'columns' => $columns]
        );
    }


    public function getTsats(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_tsatRepository, 'findTsatByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createTsat(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $tsat = $this->_tsatRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "tsatable_id" => $request->tsatable_id,
                "tsatable_type" => $request->tsatable_type
            ]);

            $tsat->setTsat($request->tsat);

            $this->setAuditableInformationFromRequest($tsat, $request);

            $rules = [
                'departure_id' => 'required',
                'tsat' => 'required',
                'tsatable_id' => 'required',
                'tsatable_type' => 'required'
            ];

            $brokenRules = $tsat->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $tsatResult = $unitOfWork->markNewAndSaveChange($this->_tsatRepository, $tsat);

            $response->dto = $tsatResult;
            $response->addInfoMessageResponse('TSAT created');

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }


    public function getTtots(int $departureId): GenericCollectionResponse
    {
        return $this->search(
            [$this->_ttotRepository, 'findTtotByDepartureId'],
            ['departureId' => $departureId]
        );
    }

    public function createTtot(CreateElementRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $ttot = $this->_ttotRepository->newInstance([
                "departure_id" => $request->departure_id,
                "reason" => $request->reason,
                "ttotable_id" => $request->ttotable_id,
                "ttotable_type" => $request->ttotable_type
            ]);

            $ttot->setTtot($request->ttot);

            $this->setAuditableInformationFromRequest($ttot, $request);

            $rules = [
                'departure_id' => 'required',
                'ttot' => 'required',
                'ttotable_id' => 'required',
                'ttotable_type' => 'required'
            ];

            $brokenRules = $ttot->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $ttotResult = $unitOfWork->markNewAndSaveChange($this->_ttotRepository, $ttot);

            $response->dto = $ttotResult;
            $response->addInfoMessageResponse('TTOT created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
