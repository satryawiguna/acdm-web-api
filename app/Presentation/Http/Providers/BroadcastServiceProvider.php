<?php

namespace App\Presentation\Http\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Broadcast::routes();

        Broadcast::routes([
            'middleware' => ['check.client.credentials', 'auth:api'],
            'prefix' => 'api'
        ]);

        require base_path('routes/channels.php');
    }
}
