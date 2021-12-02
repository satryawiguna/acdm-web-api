<?php
namespace App\Service\Contracts\Membership\Request;


use App\Core\Service\Request\IdentityAuditableRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserProfileRequest",
 *     title="Update User Profile Request",
 *     description="Update user profile request schema",
 *     required={"profile"}
 * )
 */
class UpdateUserProfileRequest extends IdentityAuditableRequest
{
    // User
    /**
     * @OA\Property(
     *     property="email",
     *     description="Email property",
     *     type="string"
     * )
     */
    public string $email;

    /**
     * @OA\Property(
     *     property="username",
     *     description="Username property",
     *     type="string"
     * )
     */
    public string $username;

    /**
     * @OA\Property(
     *     property="password",
     *     description="Password property",
     *     type="string"
     * )
     */
    public string $password;

    /**
     * @OA\Property(
     *     property="password_confirm",
     *     description="Password confirm property",
     *     type="string"
     * )
     */
    public string $password_confirm;

    /**
     * @OA\Property(
     *     property="status",
     *     description="Status property",
     *     type="string"
     * )
     */
    public string $status;

    // Profile
    /**
     * @OA\Property(
     *     property="profile",
     *     description="Profile property",
     *     type="object",
     *     ref="#/components/schemas/CreateProfileRequest"
     * )
     */
    public object $profile;

    // Media
    /**
     * @OA\Property(
     *      property="media",
     *      description="Medias property",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(
     *              property="media_id",
     *              description="Media id property",
     *              type="string",
     *              example="152cc099-56a2-46b6-b2a8-ebc080477e3a"
     *          ),
     *          @OA\Property(
     *              property="pivot",
     *              description="Pivot property",
     *              @OA\Property(
     *                  property="attribute",
     *                  type="string",
     *                  example="featured"
     *              )
     *          )
     *      )
     * )
    */
    public ?array $media;

    // Role
    /**
     * @OA\Property(
     *     property="roles",
     *     description="Role ids property",
     *     type="array",
     *     @OA\Items(
     *         type="integer",
     *         format="int64"
     *     ),
     *     example={1}
     * )
     */
    public ?array $roles;

    /**
     * @return object
     */
    public function getProfile(): object
    {
        return $this->profile;
    }

    /**
     * @param object $profile
     */
    public function setProfile(object $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * @return array|null
     */
    public function getMedias(): ?array
    {
        return $this->medias;
    }

    /**
     * @param array|null $medias
     */
    public function setMedias(?array $medias): void
    {
        $this->medias = $medias;
    }
}
