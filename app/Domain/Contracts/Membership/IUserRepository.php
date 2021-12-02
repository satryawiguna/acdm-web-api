<?php
namespace App\Domain\Contracts\Membership;


use App\Core\Domain\Contracts\IRepository;
use App\Core\Domain\Contracts\Pagination\ListSearchParameter;
use App\Core\Domain\Contracts\Pagination\ListSearchResult;
use App\Core\Domain\Contracts\Pagination\PageSearchParameter;
use App\Core\Domain\Contracts\Pagination\PageSearchResult;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Membership\IUserModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Profile\IProfileModelFacade;
use Illuminate\Support\Collection;

interface IUserRepository extends IRepository
{
    public function __construct(IUserModelFacade $eloquent,
                                IProfileModelFacade $profileModelFacade);

    public function findUsers(): Collection;

    public function findUsersListSearch(ListSearchParameter $parameter, array $column = ['*']): ListSearchResult;

    public function findUsersPageSearch(PageSearchParameter $parameter, array $column = ['*']): PageSearchResult;

    public function findUser(int $id): BaseEloquent;

    public function findUserProfile(int $id): BaseEloquent;

    public function findUserProfilesGroupByRole(): Collection;

    public function findUserGroup(int $id): Collection;

    public function findUserRoles(int $id): Collection;

    public function findUserPermission(int $id, int $permissionId): BaseEloquent;

    public function findUserPermissions(int $id): Collection;

    public function findUserAccess(int $id, int $permissionId, int $accessId): BaseEloquent;

    public function findUserAccesses(int $id, int $permissionId): Collection;

    public function findUserLogin(string $identity): Collection;

    public function findUserLoginToApiDocument(string $email): Collection;
}
