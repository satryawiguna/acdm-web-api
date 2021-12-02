<?php
namespace App\Infrastructure\Persistence\ModelFacades\Contracts\Profile;


use App\Infrastructure\Persistence\ModelFacades\Contracts\IModelFacade;
use DateTime;

interface IProfileModelFacade extends IModelFacade
{
    public function findWhereByKeyword(string $keyword): IModelFacade;

    public function findWhereByGender(string $gender): IModelFacade;

    public function findWhereBetweenByRangeFoundedDate(DateTime $startDate, Datetime $endDate): IModelFacade;

    public function findWhereBetweenByRangeBirthDate(DateTime $startDate, Datetime $endDate): IModelFacade;
}
