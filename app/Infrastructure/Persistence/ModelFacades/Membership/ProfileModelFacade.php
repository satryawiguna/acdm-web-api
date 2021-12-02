<?php
namespace App\Infrastructure\Persistence\ModelFacades\Membership;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Profile\IProfileModelFacade;
use DateTime;
use Illuminate\Support\Facades\Config;

class ProfileModelFacade extends BaseModelFacade implements IProfileModelFacade
{
    public function findWhereByKeyword(string $keyword): IModelFacade
    {
        $parameter = [
            'country' => '%' . $keyword . '%',
            'state' => '%' . $keyword . '%',
            'city' => '%' . $keyword . '%',
            'address' => '%' . $keyword . '%',
            'email' => '%' . $keyword . '%',
            'url' => '%' . $keyword . '%',
        ];

        $this->model = $this->model->whereRaw('(country LIKE ?
            OR state LIKE ?
            OR city LIKE ?
            OR address LIKE ?
            OR email LIKE ?
            OR url LIKE ?)', $parameter);

        return $this;
    }

    public function findWhereByGender(string $gender): IModelFacade
    {
        $this->model = $this->model->where('gender', $gender);

        return $this;
    }

    public function findWhereBetweenByRangeFoundedDate(DateTime $startDate, DateTime $endDate): IModelFacade
    {
        $this->model = $this->model->whereBetween('founded_date', [
            $startDate->format(Config::get('datetime.format.default')),
            $endDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    public function findWhereBetweenByRangeBirthDate(DateTime $startDate, DateTime $endDate): IModelFacade
    {
        $this->model = $this->model->whereBetween('birth_date', [
            $startDate->format(Config::get('datetime.format.default')),
            $endDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }
}
