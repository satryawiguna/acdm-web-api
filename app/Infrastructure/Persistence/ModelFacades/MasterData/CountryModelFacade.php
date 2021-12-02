<?php


namespace App\Infrastructure\Persistence\ModelFacades\MasterData;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\ICountryModelFacade;

class CountryModelFacade extends BaseModelFacade implements ICountryModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'name' => '%' . $keyword . '%'
        ];

        $this->model = $this->model->whereRaw('(name LIKE ?)', $parameter);

        return $this;
    }

    public function findWhereByCallingCode(string $calling_code)
    {
        $this->model = $this->model->where('calling_code', '=', $calling_code);

        return $this;
    }

    public function findWhereByIsoCodeTwoDigit(string $iso_code_two_digit)
    {
        $this->model = $this->model->where('iso_code_two_digit', '=', $iso_code_two_digit);

        return $this;
    }

    public function findWhereByIsoCodeThreeDigit(string $iso_code_three_digit)
    {
        $this->model = $this->model->where('iso_code_three_digit', '=', $iso_code_three_digit);

        return $this;
    }
}
