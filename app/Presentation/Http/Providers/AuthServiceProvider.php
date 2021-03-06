<?php
namespace App\Presentation\Http\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
//        Passport::tokensExpireIn(Carbon::now()->addSecond(5));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
//        Passport::refreshTokensExpireIn(Carbon::now()->addMinute(1));
    }
}
