<?php
namespace App\Infrastructure\Persistence\Repositories\System;


use App\Domain\Contracts\System\IGroupRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IGroupModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class GroupRepository extends BaseRepository implements IGroupRepository
{
    public function __construct(IGroupModelFacade $context)
    {
        parent::__construct($context);
    }
}
