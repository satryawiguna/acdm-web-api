<?php
namespace App\Presentation\Http\Providers;


use App\Core\Domain\Contracts\IUnitOfWork;
use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Infrastructure\Persistence\UnitOfWork\UnitOfWork;
use App\Infrastructure\Persistence\UnitOfWork\UnitOfWorkFactory;
use Illuminate\Support\ServiceProvider;

class UnitOfWorkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUnitOfWorkFactory::class, UnitOfWorkFactory::class);
        $this->app->bind(IUnitOfWork::class, UnitOfWork::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
