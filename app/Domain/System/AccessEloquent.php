<?php
namespace App\Domain\System;


use App\Domain\Membership\UserEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IAccessEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="AccessEloquent",
 *     title="Access Eloquent",
 *     description="Access eloquent schema",
 *     required={"name", "slug"}
 * )
 */
class AccessEloquent extends BaseEloquent implements IAccessEloquent
{
    use Notifiable, SoftDeletes, Sluggable;

    protected $table = IAccessEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'description',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'name', 'slug', 'description',
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
     *     property="description",
     *     type="string",
     *     description="Description property"
     * )
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

    public function permissions()
    {
        return $this->belongsToMany(PermissionEloquent::class, 'permission_accesses', 'access_id', 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(UserEloquent::class, 'user_accesses', 'access_id', 'user_id');
    }
}
