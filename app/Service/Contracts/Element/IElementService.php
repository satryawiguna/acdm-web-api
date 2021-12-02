<?php
namespace App\Service\Contracts\Element;


use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Service\Contracts\Element\Request\CreateElementRequest;

interface IElementService
{
    public function getAcgts(int $departureId): GenericCollectionResponse;

    public function createAcgt(CreateElementRequest $request): GenericObjectResponse;


    public function getAczts(int $departureId): GenericCollectionResponse;

    public function createAczt(CreateElementRequest $request): GenericObjectResponse;


    public function getAdits(int $departureId): GenericCollectionResponse;

    public function createAdit(CreateElementRequest $request): GenericObjectResponse;


    public function getAegts(int $departureId): GenericCollectionResponse;

    public function createAegt(CreateElementRequest $request): GenericObjectResponse;


    public function getAezts(int $departureId): GenericCollectionResponse;

    public function createAezt(CreateElementRequest $request): GenericObjectResponse;


    public function getAghts(int $departureId): GenericCollectionResponse;

    public function createAght(CreateElementRequest $request): GenericObjectResponse;


    public function getAobts(int $departureId): GenericCollectionResponse;

    public function createAobt(CreateElementRequest $request): GenericObjectResponse;


    public function getArdts(int $departureId): GenericCollectionResponse;

    public function createArdt(CreateElementRequest $request): GenericObjectResponse;


    public function getArzts(int $departureId): GenericCollectionResponse;

    public function createArzt(CreateElementRequest $request): GenericObjectResponse;


    public function getAsbts(int $departureId): GenericCollectionResponse;

    public function createAsbt(CreateElementRequest $request): GenericObjectResponse;


    public function getAsrts(int $depatureId): GenericCollectionResponse;

    public function createAsrt(CreateElementRequest $request): GenericObjectResponse;


    public function getAtets(int $departureId): GenericCollectionResponse;

    public function createAtet(CreateElementRequest $request): GenericObjectResponse;


    public function getAtots(int $departureId): GenericCollectionResponse;

    public function createAtot(CreateElementRequest $request): GenericObjectResponse;


    public function getAtsts(int $departureId): GenericCollectionResponse;

    public function createAtst(CreateElementRequest $request): GenericObjectResponse;


    public function getAttts(int $departureId): GenericCollectionResponse;

    public function createAttt(CreateElementRequest $request): GenericObjectResponse;


    public function getAxots(int $departureId): GenericCollectionResponse;

    public function createAxot(CreateElementRequest $request): GenericObjectResponse;


    public function getAzats(int $departureId): GenericCollectionResponse;

    public function createAzat(CreateElementRequest $request): GenericObjectResponse;


    public function getCtots(int $departureId): GenericCollectionResponse;

    public function createCtot(CreateElementRequest $request): GenericObjectResponse;


    public function getEczts(int $departureId): GenericCollectionResponse;

    public function createEczt(CreateElementRequest $request): GenericObjectResponse;


    public function getEdits(int $departureId): GenericCollectionResponse;

    public function createEdit(CreateElementRequest $request): GenericObjectResponse;


    public function getEezts(int $departureId): GenericCollectionResponse;

    public function createEezt(CreateElementRequest $request): GenericObjectResponse;


    public function getEobts(int $departureId): GenericCollectionResponse;

    public function createEobt(CreateElementRequest $request): GenericObjectResponse;


    public function getErzts(int $departureId): GenericCollectionResponse;

    public function createErzt(CreateElementRequest $request): GenericObjectResponse;


    public function getEtots(int $departureId): GenericCollectionResponse;

    public function createEtot(CreateElementRequest $request): GenericObjectResponse;


    public function getExots(int $departureId): GenericCollectionResponse;

    public function createExot(CreateElementRequest $request): GenericObjectResponse;


    public function getSobts(int $departureId): GenericCollectionResponse;

    public function createSobt(CreateElementRequest $request): GenericObjectResponse;


    public function getStets(int $departureId): GenericCollectionResponse;

    public function createStet(CreateElementRequest $request): GenericObjectResponse;


    public function getStsts(int $departureId): GenericCollectionResponse;

    public function createStst(CreateElementRequest $request): GenericObjectResponse;


    public function getTobts(int $departureId): GenericCollectionResponse;

    public function createTobt(CreateElementRequest $request): GenericObjectResponse;

    public function showTobt(int $id, array $columns = ['*']): GenericObjectResponse;


    public function getTsats(int $departureId): GenericCollectionResponse;

    public function createTsat(CreateElementRequest $request): GenericObjectResponse;


    public function getTtots(int $departureId): GenericCollectionResponse;

    public function createTtot(CreateElementRequest $request): GenericObjectResponse;
}
