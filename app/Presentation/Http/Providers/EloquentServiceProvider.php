<?php
namespace App\Presentation\Http\Providers;


use App\Domain\Departure\DepartureEloquent;
use App\Domain\Departure\DepartureMetaEloquent;
use App\Domain\Element\AcgtEloquent;
use App\Domain\Element\AcztEloquent;
use App\Domain\Element\AditEloquent;
use App\Domain\Element\AegtEloquent;
use App\Domain\Element\AeztEloquent;
use App\Domain\Element\AghtEloquent;
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
use App\Domain\Element\StetEloquent;
use App\Domain\Element\StstEloquent;
use App\Domain\Element\TobtEloquent;
use App\Domain\Element\TsatEloquent;
use App\Domain\Element\TtotEloquent;
use App\Domain\MasterData\AirlineEloquent;
use App\Domain\MasterData\AirportEloquent;
use App\Domain\MasterData\CountryEloquent;
use App\Domain\MasterData\OrganizationEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\Media\MediaEloquent;
use App\Domain\Membership\ProfileEloquent;
use App\Domain\Membership\UserEloquent;
use App\Domain\System\GroupEloquent;
use App\Domain\System\PermissionEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAcgtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAcztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAditEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAegtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAeztEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IAghtEloquent;
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
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IStetEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\IStstEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITobtEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITsatEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Element\ITtotEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Departure\IDepartureEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Departure\IDepartureMetaEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IAirlineEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IAirportEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\ICountryEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IOrganizationEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\MasterData\IVendorEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Media\IMediaEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IProfileEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\Membership\IUserEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IGroupEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IPermissionEloquent;
use App\Infrastructure\Persistence\Eloquents\Contracts\System\IRoleEloquent;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //System
        $this->app->bind(IGroupEloquent::class, GroupEloquent::class);
        $this->app->bind(IPermissionEloquent::class, PermissionEloquent::class);
        $this->app->bind(IRoleEloquent::class, RoleEloquent::class);

        //Membership
        $this->app->bind(IUserEloquent::class, UserEloquent::class);
        $this->app->bind(IProfileEloquent::class, ProfileEloquent::class);

        //Media
        $this->app->bind(IMediaEloquent::class, MediaEloquent::class);

        //Master Data
        $this->app->bind(IAirportEloquent::class, AirportEloquent::class);
        $this->app->bind(IAirlineEloquent::class, AirlineEloquent::class);
        $this->app->bind(IVendorEloquent::class, VendorEloquent::class);
        $this->app->bind(ICountryEloquent::class, CountryEloquent::class);
        $this->app->bind(IOrganizationEloquent::class, OrganizationEloquent::class);

        //Departure
        $this->app->bind(IDepartureEloquent::class, DepartureEloquent::class);
        $this->app->bind(IDepartureMetaEloquent::class, DepartureMetaEloquent::class);
        $this->app->bind(IFlightInformationEloquent::class, FlightInformationEloquent::class);

        //Departure Element
        $this->app->bind(IAcgtEloquent::class, AcgtEloquent::class);
        $this->app->bind(IAcztEloquent::class, AcztEloquent::class);
        $this->app->bind(IAditEloquent::class, AditEloquent::class);
        $this->app->bind(IAegtEloquent::class, AegtEloquent::class);
        $this->app->bind(IAeztEloquent::class, AeztEloquent::class);
        $this->app->bind(IAghtEloquent::class, AghtEloquent::class);
        $this->app->bind(IArztEloquent::class, ArztEloquent::class);
        $this->app->bind(IAsbtEloquent::class, AsbtEloquent::class);
        $this->app->bind(IAsrtEloquent::class, AsrtEloquent::class);
        $this->app->bind(IAtetEloquent::class, AtetEloquent::class);
        $this->app->bind(IAtotEloquent::class, AtotEloquent::class);
        $this->app->bind(IAtstEloquent::class, AtstEloquent::class);
        $this->app->bind(IAtttEloquent::class, AtttEloquent::class);
        $this->app->bind(IAxotEloquent::class, AxotEloquent::class);
        $this->app->bind(IAzatEloquent::class, AzatEloquent::class);
        $this->app->bind(ICtotEloquent::class, CtotEloquent::class);
        $this->app->bind(IEcztEloquent::class, EcztEloquent::class);
        $this->app->bind(IEditEloquent::class, EditEloquent::class);
        $this->app->bind(IEeztEloquent::class, EeztEloquent::class);
        $this->app->bind(IEobtEloquent::class, EobtEloquent::class);
        $this->app->bind(IErztEloquent::class, ErztEloquent::class);
        $this->app->bind(IEtotEloquent::class, EtotEloquent::class);
        $this->app->bind(IExotEloquent::class, ExotEloquent::class);
        $this->app->bind(IStetEloquent::class, StetEloquent::class);
        $this->app->bind(IStstEloquent::class, StstEloquent::class);
        $this->app->bind(ITobtEloquent::class, TobtEloquent::class);
        $this->app->bind(ITsatEloquent::class, TsatEloquent::class);
        $this->app->bind(ITtotEloquent::class, TtotEloquent::class);
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
