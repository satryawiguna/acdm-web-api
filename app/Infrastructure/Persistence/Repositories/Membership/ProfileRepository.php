<?php
namespace App\Infrastructure\Persistence\Repositories\Membership;


use App\Domain\Contracts\Membership\IProfileRepository;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Profile\IProfileModelFacade;
use App\Infrastructure\Persistence\Repositories\BaseRepository;

class ProfileRepository extends BaseRepository implements IProfileRepository
{
    public function __construct(IProfileModelFacade $context)
    {
        parent::__construct($context);
    }
}
