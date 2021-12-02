<?php
namespace App\Domain\Membership;


use App\Domain\Auth\OAuthAccessTokenEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\System\AccessEloquent;
use App\Domain\System\GroupEloquent;
use App\Domain\System\PermissionEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\AuthEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IProfileEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IUserEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="UserEloquent",
 *     title="User Eloquent",
 *     description="User eloquent schema",
 *     required={"username", "email", "password"}
 * )
 */
class UserEloquent extends AuthEloquent implements IUserEloquent
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $table = IUserEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
       'username', 'email', 'password', 'status', 'last_login_at', 'last_login_ip',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'username', 'email', 'status', 'last_login_at', 'last_login_ip',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'username', 'email', 'last_login_at', 'last_login_ip',
        'created_at', 'updated_at'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates = [
        'deleted_at'
    ];
    public $timestamps = false;

    /**
     * @OA\Property(
     *     property="username",
     *     type="string",
     *     description="Username property"
     * )
     *
     * @return string
     * @var string
     */

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email property"
     * )
     *
     * @return string
     * @var string
     */

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="Password property"
     * )
     *
     * @return string
     * @var string
     */

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="status",
     *     type="array",
     *     description="Status property",
     *     @OA\Items(
     *         example={"PENDING", "ACTIVE", "DISABLE", "BLOCK"}
     *     )
     * )
     *
     * @return string
     * @var string
     */

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    public function getLastLoginAt(): DateTime
    {
        return new DateTime($this->last_login_at);
    }

    public function setLastLoginAt(DateTime $last_login_at)
    {
        $this->last_login_at = $last_login_at->format(Config::get('datetime.format.database_datetime'));
        return $this;
    }

    public function getLastLoginIp(): string
    {
        return $this->last_login_ip;
    }

    public function setLastLoginIp(string $last_login_ip)
    {
        $this->last_login_ip = $last_login_ip;
        return $this;
    }

    /**
     * ========= Function Relation ==========
     */

    public function profile()
    {
        return $this->morphOne(ProfileEloquent::class, 'profileable');
    }

    public function roles()
    {
        return $this->belongsToMany(RoleEloquent::class, 'user_roles', 'user_id', 'role_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(VendorEloquent::class, 'user_vendors', 'user_id', 'vendor_id');
    }

    public function groups()
    {
        return $this->belongsToMany(GroupEloquent::class, 'user_groups', 'user_id', 'group_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(PermissionEloquent::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function accesses()
    {
        return $this->belongsToMany(AccessEloquent::class, 'user_accesses', 'user_id', 'access_id');
    }

    public function oAuthAccessTokens()
    {
        return $this->hasMany(OAuthAccessTokenEloquent::class, 'user_id');
    }

    public function hasRole($user, string $role)
    {
        $user = $user->with('roles')->find($user->id);

        $role = $user->roles->where('slug', $role);

        return $role->count() > 0;
    }

    public function hasPermission($user, string $permission)
    {
        $_user = $user->with(['permissions' => function ($query) use ($permission) {
            $query->select('id', 'name', 'slug', 'value')
                ->where([
                    ['slug','=',$permission]
                ]);
        }])->find($user->id);

        if ($_user->permissions->count() > 0) {
            if ($_user->permissions->first()->value == 'ALLOW') {
                return true;
            }

            if ($_user->permissions->first()->value == 'DENY') {
                return false;
            }
        }

        $__user = $user->with(['roles' => function ($query) use ($permission) {
            $query->with(['permissions' => function ($query) use ($permission) {
                $query->select('id', 'name', 'slug', 'value')
                    ->where([
                        ['slug','=',$permission]
                    ]);
            }]);
        }])->find($user->id);

        if ($__user->roles->first()->permissions->count() > 0) {
            if ($__user->roles->first()->permissions->first()->value == 'ALLOW') {
                return true;
            }

            if ($__user->roles->first()->permissions->first()->value == 'DENY') {
                return false;
            }
        }

        return false;
    }

    public function hasAccess($user, string $permission, string $access)
    {
        $permissionId = $this->findPermissionId($user, $permission);

        if (!$permissionId) {
            return false;
        }

        $_user = $user->with(['accesses' => function ($query) use ($permissionId, $access) {
            $query->select('id', 'name', 'slug', 'value')
                ->where([
                    ['slug','=',$access]
                ])
                ->wherePivot('permission_id', $permissionId);
        }])->find($user->id);

        if ($_user->accesses->count() > 0) {
            if ($_user->accesses->first()->value == 'ALLOW') {
                return true;
            }

            if ($_user->accesses->first()->value == 'DENY') {
                return false;
            }
        }

        $__user = $user->with(['roles' => function ($query) use ($permission, $access) {
            $query->with(['permissions' => function ($query) use ($permission, $access) {
                $query->select('id', 'name', 'slug', 'value')
                    ->with(['accesses' => function ($query) use ($access) {
                        $query->select('id', 'name', 'slug', 'value')
                            ->where([
                                ['slug','=',$access]
                            ]);
                    }])->where([
                        ['slug','=',$permission]
                    ]);
            }]);
        }])->find($user->id);

        if ($__user->roles->first()->permissions->first()->accesses->count() > 0) {
            if ($__user->roles->first()->permissions->first()->accesses->first()->value == 'ALLOW') {
                return true;
            }

            if ($__user->roles->first()->permissions->first()->accesses->first()->value == 'DENY') {
                return false;
            }
        }

        return false;
    }

    private function findPermissionId($user, string $permission)
    {
        $user = $user->with(['roles' => function ($query) use ($permission) {
            $query->with(['permissions' => function ($query) use ($permission) {
                $query->select('id')
                    ->where([
                        ['slug','=',$permission]
                    ]);
            }]);
        }])->find($user->id);

        if ($user->roles) {
            if ($user->roles->first()->permissions->count() > 0) {
                return $user->roles->first()->permissions->first()->id;
            }
        }

        return false;
    }

    public function tokenExpired()
    {
        if (Carbon::parse($this->attributes['expires_at']) < Carbon::now()) {
            return true;
        }

        return false;
    }
}

Relation::morphMap([
    IProfileEloquent::MORPH_NAME => ProfileEloquent::class,
]);
