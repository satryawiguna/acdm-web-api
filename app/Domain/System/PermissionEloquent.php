<?php
namespace App\Domain\System;


use App\Domain\Membership\UserEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IPermissionEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="PermissionEloquent",
 *     title="Permission Eloquent",
 *     description="Permission eloquent schema",
 *     required={"name", "slug", "server", "path"}
 * )
 */
class PermissionEloquent extends BaseEloquent implements IPermissionEloquent
{
    use Notifiable, SoftDeletes, Sluggable;

    protected $table = IPermissionEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'server', 'path', 'description',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'name', 'slug', 'server', 'path', 'description',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'name', 'slug',
        'created_at', 'updated_at'
    ];
    public $timestamps = false;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property"
     * )
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="slug",
     *     type="string",
     *     description="Slug property"
     * )
     *
     * @return string
     * @var string
     */

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="server",
     *     type="string",
     *     description="Server property"
     * )
     *
     * @return string
     * @var string
     */

    public function getServer(): string
    {
        return $this->server;
    }

    public function setServer(string $server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="path",
     *     type="string",
     *     description="Path property"
     * )
     *
     * @return string
     * @var string
     */

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description property"
     * )
     *
     * @return string
     * @var string
     */

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * ========= Function Relation ==========
     */

    public function roles()
    {
        return $this->belongsToMany(RoleEloquent::class, 'role_permissions', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_permissions', 'permission_id', 'user_id');
    }

    public function accesses()
    {
        return $this->belongsToMany(AccessEloquent::class, 'permission_accesses', 'permission_id', 'access_id');
    }
}

/**
 * @OA\Schema(
 *     schema="PermissionAccessResponse",
 *     title="Permission access Response",
 *     description="Permission access response schema",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
 *         @OA\Schema(ref="#/components/schemas/PermissionEloquent"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="accesses",
 *                 type="array",
 *                 @OA\Items(
 *                      allOf={
 *                          @OA\Schema(ref="#/components/schemas/IdentityAuditableRequest"),
 *                          @OA\Schema(ref="#/components/schemas/AccessEloquent")
 *                      }
 *                 )
 *             )
 *         )
 *     }
 * )
 */
