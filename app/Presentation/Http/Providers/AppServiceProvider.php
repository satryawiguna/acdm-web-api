<?php
namespace App\Presentation\Http\Providers;


use App\Service\Auth\AuthService;
use App\Service\Contracts\Auth\IAuthService;
use App\Service\Contracts\Departure\IDepartureService;
use App\Service\Contracts\Departure\IFlightInformationService;
use App\Service\Contracts\Element\IElementService;
use App\Service\Contracts\MasterData\IMasterDataService;
use App\Service\Contracts\Media\IMediaService;
use App\Service\Contracts\Membership\IMembershipService;
use App\Service\Contracts\System\ISystemService;
use App\Service\Departure\DepartureService;
use App\Service\Departure\FlightInformationService;
use App\Service\Element\ElementService;
use App\Service\MasterData\MasterDataService;
use App\Service\Media\MediaService;
use App\Service\Membership\MembershipService;
use App\Service\System\SystemService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(ISystemService::class, SystemService::class);
        $this->app->bind(IMembershipService::class, MembershipService::class);
        $this->app->bind(IMediaService::class, MediaService::class);
        $this->app->bind(IMasterDataService::class, MasterDataService::class);
        $this->app->bind(IDepartureService::class, DepartureService::class);
        $this->app->bind(IFlightInformationService::class, FlightInformationService::class);
        $this->app->bind(IElementService::class, ElementService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //Force scheme to https
        URL::forceScheme('https');

        //Update or Create
        HasMany::macro('sync', function (array $data, $deleting = true) {
            $changes = [
                'created' => [], 'deleted' => [], 'updated' => [],
            ];

            /** @var HasMany $this */
            $relatedKeyName = $this->getRelated()->getKeyName();

            $current = $this->newQuery()->pluck($relatedKeyName)->all();

            $castKey = function ($value) {
                if (is_null($value)) {
                    return $value;
                }

                return is_numeric($value) ? (int) $value : (string) $value;
            };

            $castKeys = function ($keys) use ($castKey) {
                return (array) array_map(function ($key) use ($castKey) {
                    return $castKey($key);
                }, $keys);
            };

            $deletedKeys = array_diff($current, $castKeys(
                    Arr::pluck($data, $relatedKeyName))
            );

            if ($deleting && count($deletedKeys) > 0) {
                $this->getRelated()->destroy($deletedKeys);
                $changes['deleted'] = $deletedKeys;
            }

            $newRows = Arr::where($data, function ($row) use ($relatedKeyName) {
                return Arr::get($row, $relatedKeyName) === null;
            });

            $updatedRows = Arr::where($data, function ($row) use ($relatedKeyName) {
                return Arr::get($row, $relatedKeyName) !== null;
            });

            if (count($newRows) > 0) {
                $newRecords = $this->createMany($newRows);
                $changes['created'] = $castKeys(
                    $newRecords->pluck($relatedKeyName)->toArray()
                );
            }

            foreach ($updatedRows as $row) {
                $this->getRelated()->where($relatedKeyName, $castKey(Arr::get($row, $relatedKeyName)))
                    ->update($row);
            }

            $changes['updated'] = $castKeys(Arr::pluck($updatedRows, $relatedKeyName));

            return $changes;
        });
    }
}
