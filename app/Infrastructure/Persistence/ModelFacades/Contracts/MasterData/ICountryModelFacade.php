<?php


namespace App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;

interface ICountryModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword);

    public function findWhereByCallingCode(string $calling_code);

    public function findWhereByIsoCodeTwoDigit(string $iso_code_two_digit);

    public function findWhereByIsoCodeThreeDigit(string $iso_code_three_digit);
}
