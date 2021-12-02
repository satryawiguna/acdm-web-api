<?php
namespace App\Infrastructure\Persistence\Repositories\System;


use App\Domain\Contracts\System\IAccessRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IAccessModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;
use Ramsey\Collection\Collection;

class AccessRepository extends BaseRepository implements IAccessRepository
{
    public function __construct(IAccessModelFacade $context)
    {
        parent::__construct($context);
    }
}
