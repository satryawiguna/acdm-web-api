<?php
namespace App\Domain\Membership;


use App\Domain\Media\MediaEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Media\IMediaEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IUserEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IProfileEloquent;
use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

/**
 * @OA\Schema(
 *     schema="ProfileEloquent",
 *     title="Profile Eloquent",
 *     description="Profile eloquent schema",
 *     required={"profileable_id", "profileable_type", "email", "password"}
 * )
 */
class ProfileEloquent extends BaseEloquent implements IProfileEloquent
{
    use Notifiable, SoftDeletes;

    protected $table = IProfileEloquent::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $fillable = [
        'profileable_id', 'profileable_type', 'full_name', 'nick_name', 'country', 'state', 'city', 'address', 'postcode', 'gender', 'birth_date', 'mobile', 'email',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $searchable = [
        'profileable_id', 'profileable_type', 'full_name', 'nick_name', 'country', 'state', 'city', 'address', 'gender', 'birth_date', 'email',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];
    protected $orderable = [
        'full_name', 'nick_name', 'country', 'state', 'city', 'gender', 'birth_date', 'email',
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    public $timestamps = false;

    protected $attributes = [
        'roles' => null,
        'vendors' => null
    ];

    /**
     * @OA\Property(
     *     property="profileable_id",
     *     type="integer",
     *     format="int64",
     *     description="Profileable id property"
     * )
     */
    public function getProfileableId(): int
    {
        return $this->profileable_id;
    }

    public function setProfileableId(int $profileable_id)
    {
        $this->profileable_id = $profileable_id;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="profileable_type",
     *     type="string",
     *     description="Profileable type property"
     * )
     */
    public function getProfileableType(): string
    {
        return $this->profileable_type;
    }

    public function setProfileableType(string $profileable_type)
    {
        $this->profileable_type = $profileable_type;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="full_name",
     *     type="string",
     *     description="Full name property"
     * )
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name)
    {
        $this->full_name = $full_name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="nick_name",
     *     type="string",
     *     description="Nick name property"
     * )
     */
    public function getNickName(): ?string
    {
        return $this->nick_name;
    }

    public function setNickName(?string $nick_name)
    {
        $this->nick_name = $nick_name;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Country property"
     * )
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="state",
     *     type="string",
     *     description="State property"
     * )
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="City property"
     * )
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Address property"
     * )
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="postcode",
     *     type="string",
     *     description="Postcode property"
     * )
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="gender",
     *     type="string",
     *     description="Gender property"
     * )
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="birth_date",
     *     type="string",
     *     format="date-time",
     *     description="Birth date property"
     * )
     */
    public function getBirthDate(): ?DateTime
    {
        return new DateTime($this->birth_date);
    }

    public function setBirthDate(?DateTime $birth_date)
    {
        $this->birth_date = $birth_date->format(Config::get('datetime.format.database_datetime'));
        return $this;
    }

    /**
     * @OA\Property(
     *     property="mobile",
     *     type="string",
     *     description="Mobile property"
     * )
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email property"
     * )
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

    public function profileable()
    {
        return $this->morphTo();
    }

    public function media()
    {
        return $this->morphToMany(MediaEloquent::class,
            'mediable',
            'mediables',
            'mediable_id',
            'media_id');
    }
}

Relation::morphMap([
    IUserEloquent::MORPH_NAME => UserEloquent::class,
    IMediaEloquent::MORPH_NAME => MediaEloquent::class
]);
