<?php
namespace App\Domain\Auth;


use App\Domain\Membership\UserEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Auth\IOAuthAccessTokenEloquent;
use Illuminate\Notifications\Notifiable;

class OAuthAccessTokenEloquent extends BaseEloquent implements IOAuthAccessTokenEloquent
{
    use Notifiable;

    protected $table = IOAuthAccessTokenEloquent::TABLE_NAME;
    protected $primaryKey = 'id';

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function setScope(string $scope)
    {
        $this->scope = $scope;
        return $this;
    }

    public function getRevoked(): int
    {
        return $this->revoked;
    }

    public function setRevoked(int $revoked)
    {
        $this->revoked = $revoked;
        return $this;
    }

    /**
     * ========= Function Relation ==========
     */

        public function user()
        {
            return $this->belongsTo(UserEloquent::class, 'user_id');
        }
}
