<?php


namespace App\Domain\MasterData;

use App\Domain\Departure\DepartureEloquent;
use App\Domain\Element\AcgtEloquent;
use App\Domain\Element\AcztEloquent;
use App\Domain\Element\AditEloquent;
use App\Domain\Element\AegtEloquent;
use App\Domain\Element\AeztEloquent;
use App\Domain\Element\AghtEloquent;
use App\Domain\Element\AobtEloquent;
use App\Domain\Element\ArdtEloquent;
use App\Domain\Element\ArztEloquent;
use App\Domain\Element\AsbtEloquent;
use App\Domain\Element\AsrtEloquent;
use App\Domain\Element\AtetEloquent;
use App\Domain\Element\AtotEloquent;
use App\Domain\Element\AtstEloquent;
use App\Domain\Element\AtttEloquent;
use App\Domain\Element\AxotEloquent;
use App\Domain\Element\AzatEloquent;
use App\Domain\Element\CtotEloquent;
use App\Domain\Element\EcztEloquent;
use App\Domain\Element\EditEloquent;
use App\Domain\Element\EeztEloquent;
use App\Domain\Element\EobtEloquent;
use App\Domain\Element\ErztEloquent;
use App\Domain\Element\EtotEloquent;
use App\Domain\Element\ExotEloquent;
use App\Domain\Element\SobtEloquent;
use App\Domain\Element\StetEloquent;
use App\Domain\Element\StstEloquent;
use App\Domain\Element\TobtEloquent;
use App\Domain\Element\TsatEloquent;
use App\Domain\Element\TtotEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Departure\IDepartureEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAcgtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAcztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAditEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAegtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAeztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAghtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IArdtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IArztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAsbtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAsrtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtetEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtstEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAtttEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAxotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAzatEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ICtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEcztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEditEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEeztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IErztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IEtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IExotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ISobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IStetEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IStstEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITsatEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="VendorEloquent",
 *     title="Vendor Eloquent",
 *     description="Vendor eloquent schema",
 *     required={"name", "slug"}
 * )
 */
class VendorEloquent extends BaseEloquent implements IVendorEloquent
{
    use Notifiable, SoftDeletes, Sluggable;

    protected $table = IVendorEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_id', 'organization_id', 'name', 'slug',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'role_id', 'organization_id', 'name', 'slug',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'role_id', 'organization_id', 'name', 'slug',
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
     *     property="role_id",
     *     type="integer",
     *     format="int32",
     *     description="Role id property"
     * )
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function setRoleId(int $role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="organization_id",
     *     type="integer",
     *     format="int64",
     *     description="Organization id property"
     * )
     */
    public function getOrganizationId(): int
    {
        return $this->organization_id;
    }

    public function setOrganizationId(int $organization_id)
    {
        $this->organization_id = $organization_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name property"
     * )
     *
     * @return string
     * @var string
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

    public function roles()
    {
        return $this->belongsTo(RoleEloquent::class, 'role_id');
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationEloquent::class, 'organization_id');
    }

    public function departureByFlightNumber()
    {
        return $this->morphOne(DepartureEloquent::class, 'flightNumberable');
    }

    public function departureByNature()
    {
        return $this->morphOne(DepartureEloquent::class, 'natureable');
    }

    public function departureByAcft()
    {
        return $this->morphOne(DepartureEloquent::class, 'acftable');
    }

    public function departureByRegister()
    {
        return $this->morphOne(DepartureEloquent::class, 'registerable');
    }

    public function departureByStand()
    {
        return $this->morphOne(DepartureEloquent::class, 'standable');
    }

    public function departureByGateName()
    {
        return $this->morphOne(DepartureEloquent::class, 'gateNameable');
    }

    public function departureByGateOpen()
    {
        return $this->morphOne(DepartureEloquent::class, 'gateOpenable');
    }

    public function departureByRunwayActual()
    {
        return $this->morphOne(DepartureEloquent::class, 'runwayActualable');
    }

    public function departureByRunwayEstimate()
    {
        return $this->morphOne(DepartureEloquent::class, 'runwayEstimateable');
    }

    public function departureByTransit()
    {
        return $this->morphOne(DepartureEloquent::class, 'runwayTransitable');
    }

    public function departureByDestination()
    {
        return $this->morphOne(DepartureEloquent::class, 'destinationable');
    }

    public function departureByDataOrigin()
    {
        return $this->morphOne(DepartureEloquent::class, 'dataOriginable');
    }

    public function acgt()
    {
        return $this->morphOne(DepartureEloquent::class, 'abgtable');
    }
}

Relation::morphMap([
    IDepartureEloquent::MORPH_NAME => DepartureEloquent::class,
    IAcgtEloquent::MORPH_NAME => AcgtEloquent::class,
    IAcztEloquent::MORPH_NAME => AcztEloquent::class,
    IAditEloquent::MORPH_NAME => AditEloquent::class,
    IAegtEloquent::MORPH_NAME => AegtEloquent::class,
    IAeztEloquent::MORPH_NAME => AeztEloquent::class,
    IAghtEloquent::MORPH_NAME => AghtEloquent::class,
    IAobtEloquent::MORPH_NAME => AobtEloquent::class,
    IArdtEloquent::MORPH_NAME => ArdtEloquent::class,
    IArztEloquent::MORPH_NAME => ArztEloquent::class,
    IAsbtEloquent::MORPH_NAME => AsbtEloquent::class,
    IAsrtEloquent::MORPH_NAME => AsrtEloquent::class,
    IAtetEloquent::MORPH_NAME => AtetEloquent::class,
    IAtotEloquent::MORPH_NAME => AtotEloquent::class,
    IAtstEloquent::MORPH_NAME => AtstEloquent::class,
    IAtttEloquent::MORPH_NAME => AtttEloquent::class,
    IAxotEloquent::MORPH_NAME => AxotEloquent::class,
    IAzatEloquent::MORPH_NAME => AzatEloquent::class,
    ICtotEloquent::MORPH_NAME => CtotEloquent::class,
    IEcztEloquent::MORPH_NAME => EcztEloquent::class,
    IEditEloquent::MORPH_NAME => EditEloquent::class,
    IEeztEloquent::MORPH_NAME => EeztEloquent::class,
    IEobtEloquent::MORPH_NAME => EobtEloquent::class,
    IErztEloquent::MORPH_NAME => ErztEloquent::class,
    IEtotEloquent::MORPH_NAME => EtotEloquent::class,
    IExotEloquent::MORPH_NAME => ExotEloquent::class,
    ISobtEloquent::MORPH_NAME => SobtEloquent::class,
    IStetEloquent::MORPH_NAME => StetEloquent::class,
    IStstEloquent::MORPH_NAME => StstEloquent::class,
    ITobtEloquent::MORPH_NAME => TobtEloquent::class,
    ITsatEloquent::MORPH_NAME => TsatEloquent::class,
    ITtotEloquent::MORPH_NAME => TtotEloquent::class
]);
