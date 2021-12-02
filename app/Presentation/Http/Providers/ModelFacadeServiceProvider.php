<?php
namespace App\Presentation\Http\Providers;


use App\Domain\Contracts\Element\AcgtModelFacade;
use App\Domain\Contracts\Element\AcztModelFacade;
use App\Domain\Contracts\Element\AditModelFacade;
use App\Domain\Contracts\Element\AegtModelFacade;
use App\Domain\Contracts\Element\AeztModelFacade;
use App\Domain\Contracts\Element\AghtModelFacade;
use App\Domain\Contracts\Element\AobtModelFacade;
use App\Domain\Contracts\Element\ArdtModelFacade;
use App\Domain\Contracts\Element\ArztModelFacade;
use App\Domain\Contracts\Element\AsbtModelFacade;
use App\Domain\Contracts\Element\AsrtModelFacade;
use App\Domain\Contracts\Element\AtetModelFacade;
use App\Domain\Contracts\Element\AtotModelFacade;
use App\Domain\Contracts\Element\AtstModelFacade;
use App\Domain\Contracts\Element\AtttModelFacade;
use App\Domain\Contracts\Element\AxotModelFacade;
use App\Domain\Contracts\Element\AzatModelFacade;
use App\Domain\Contracts\Element\CtotModelFacade;
use App\Domain\Contracts\Element\EcztModelFacade;
use App\Domain\Contracts\Element\EditModelFacade;
use App\Domain\Contracts\Element\EeztModelFacade;
use App\Domain\Contracts\Element\EobtModelFacade;
use App\Domain\Contracts\Element\ErztModelFacade;
use App\Domain\Contracts\Element\EtotModelFacade;
use App\Domain\Contracts\Element\ExotModelFacade;
use App\Domain\Contracts\Element\IAcgtModelFacade;
use App\Domain\Contracts\Element\IAcztModelFacade;
use App\Domain\Contracts\Element\IAditModelFacade;
use App\Domain\Contracts\Element\IAegtModelFacade;
use App\Domain\Contracts\Element\IAeztModelFacade;
use App\Domain\Contracts\Element\IAghtModelFacade;
use App\Domain\Contracts\Element\IAobtModelFacade;
use App\Domain\Contracts\Element\IArdtModelFacade;
use App\Domain\Contracts\Element\IArztModelFacade;
use App\Domain\Contracts\Element\IAsbtModelFacade;
use App\Domain\Contracts\Element\IAsrtModelFacade;
use App\Domain\Contracts\Element\IAtetModelFacade;
use App\Domain\Contracts\Element\IAtotModelFacade;
use App\Domain\Contracts\Element\IAtstModelFacade;
use App\Domain\Contracts\Element\IAtttModelFacade;
use App\Domain\Contracts\Element\IAxotModelFacade;
use App\Domain\Contracts\Element\IAzatModelFacade;
use App\Domain\Contracts\Element\ICtotModelFacade;
use App\Domain\Contracts\Element\IEcztModelFacade;
use App\Domain\Contracts\Element\IEditModelFacade;
use App\Domain\Contracts\Element\IEeztModelFacade;
use App\Domain\Contracts\Element\IEobtModelFacade;
use App\Domain\Contracts\Element\IErztModelFacade;
use App\Domain\Contracts\Element\IEtotModelFacade;
use App\Domain\Contracts\Element\IExotModelFacade;
use App\Domain\Contracts\Element\ISobtModelFacade;
use App\Domain\Contracts\Element\IStetModelFacade;
use App\Domain\Contracts\Element\IStstModelFacade;
use App\Domain\Contracts\Element\ITsatModelFacade;
use App\Domain\Contracts\Element\ITtotModelFacade;
use App\Domain\Contracts\Element\SobtModelFacade;
use App\Domain\Contracts\Element\StetModelFacade;
use App\Domain\Contracts\Element\StstModelFacade;
use App\Domain\Contracts\Element\TsatModelFacade;
use App\Domain\Contracts\Element\TtotModelFacade;
use App\Domain\Departure\DepartureEloquent;
use App\Domain\Departure\DepartureMetaEloquent;
use App\Domain\Departure\FlightInformationEloquent;
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
use App\Domain\MasterData\AirlineEloquent;
use App\Domain\MasterData\AirportEloquent;
use App\Domain\MasterData\CountryEloquent;
use App\Domain\MasterData\OrganizationEloquent;
use App\Domain\MasterData\VendorEloquent;
use App\Domain\Media\MediaEloquent;
use App\Domain\Membership\ProfileEloquent;
use App\Domain\Membership\UserEloquent;
use App\Domain\System\AccessEloquent;
use App\Domain\System\GroupEloquent;
use App\Domain\System\PermissionEloquent;
use App\Domain\System\RoleEloquent;
use App\Infrastructure\Persistence\Eloquents\BaseEloquent;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureMetaModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IFlightInformationModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Element\ITobtModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirlineModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IAirportModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\ICountryModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IOrganizationModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\MasterData\IVendorModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Media\IMediaModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Membership\IUserModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Profile\IProfileModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IAccessModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IGroupModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IPermissionModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\System\IRoleModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Departure\DepartureMetaModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Departure\DepartureModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Departure\FlightInformationModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Element\TobtModelFacade;
use App\Infrastructure\Persistence\ModelFacades\MasterData\AirlineModelFacade;
use App\Infrastructure\Persistence\ModelFacades\MasterData\AirportModelFacade;
use App\Infrastructure\Persistence\ModelFacades\MasterData\CountryModelFacade;
use App\Infrastructure\Persistence\ModelFacades\MasterData\OrganizationModelFacade;
use App\Infrastructure\Persistence\ModelFacades\MasterData\VendorModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Media\MediaModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Membership\ProfileModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Membership\UserModelFacade;
use App\Infrastructure\Persistence\ModelFacades\System\AccessModelFacade;
use App\Infrastructure\Persistence\ModelFacades\System\GroupModelFacade;
use App\Infrastructure\Persistence\ModelFacades\System\PermissionModelFacade;
use App\Infrastructure\Persistence\ModelFacades\System\RoleModelFacade;
use Illuminate\Support\ServiceProvider;

class ModelFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //System
        $this->app->bind(IGroupModelFacade::class, function($app) {
            $this->app->when(GroupModelFacade::class)->needs(BaseEloquent::class)->give(GroupEloquent::class);

            return $app->make(GroupModelFacade::class);
        });
        $this->app->bind(IRoleModelFacade::class, function($app) {
            $this->app->when(RoleModelFacade::class)->needs(BaseEloquent::class)->give(RoleEloquent::class);

            return $app->make(RoleModelFacade::class);
        });
        $this->app->bind(IPermissionModelFacade::class, function($app) {
            $this->app->when(PermissionModelFacade::class)->needs(BaseEloquent::class)->give(PermissionEloquent::class);

            return $app->make(PermissionModelFacade::class);
        });
        $this->app->bind(IAccessModelFacade::class, function($app) {
            $this->app->when(AccessModelFacade::class)->needs(BaseEloquent::class)->give(AccessEloquent::class);

            return $app->make(AccessModelFacade::class);
        });


        //Membership
        $this->app->bind(IUserModelFacade::class, function($app) {
            $this->app->when(UserModelFacade::class)->needs(BaseEloquent::class)->give(UserEloquent::class);

            return $app->make(UserModelFacade::class);
        });
        $this->app->bind(IProfileModelFacade::class, function($app) {
            $this->app->when(ProfileModelFacade::class)->needs(BaseEloquent::class)->give(ProfileEloquent::class);

            return $app->make(ProfileModelFacade::class);
        });

        //Media
        $this->app->bind(IMediaModelFacade::class, function($app) {
            $this->app->when(MediaModelFacade::class)->needs(BaseEloquent::class)->give(MediaEloquent::class);

            return $app->make(MediaModelFacade::class);
        });

        //Master Data
        $this->app->bind(IAirportModelFacade::class, function($app) {
            $this->app->when(AirportModelFacade::class)->needs(BaseEloquent::class)->give(AirportEloquent::class);

            return $app->make(AirportModelFacade::class);
        });
        $this->app->bind(IAirlineModelFacade::class, function($app) {
            $this->app->when(AirlineModelFacade::class)->needs(BaseEloquent::class)->give(AirlineEloquent::class);

            return $app->make(AirlineModelFacade::class);
        });
        $this->app->bind(IVendorModelFacade::class, function($app) {
            $this->app->when(VendorModelFacade::class)->needs(BaseEloquent::class)->give(VendorEloquent::class);

            return $app->make(VendorModelFacade::class);
        });
        $this->app->bind(ICountryModelFacade::class, function($app) {
            $this->app->when(CountryModelFacade::class)->needs(BaseEloquent::class)->give(CountryEloquent::class);

            return $app->make(CountryModelFacade::class);
        });
        $this->app->bind(IOrganizationModelFacade::class, function($app) {
            $this->app->when(OrganizationModelFacade::class)->needs(BaseEloquent::class)->give(OrganizationEloquent::class);

            return $app->make(OrganizationModelFacade::class);
        });


        //Departure
        $this->app->bind(IDepartureModelFacade::class, function($app) {
            $this->app->when(DepartureModelFacade::class)->needs(BaseEloquent::class)->give(DepartureEloquent::class);

            return $app->make(DepartureModelFacade::class);
        });
        $this->app->bind(IDepartureMetaModelFacade::class, function($app) {
            $this->app->when(DepartureMetaModelFacade::class)->needs(BaseEloquent::class)->give(DepartureMetaEloquent::class);

            return $app->make(DepartureMetaModelFacade::class);
        });
        $this->app->bind(IFlightInformationModelFacade::class, function($app) {
            $this->app->when(FlightInformationModelFacade::class)->needs(BaseEloquent::class)->give(FlightInformationEloquent::class);

            return $app->make(FlightInformationModelFacade::class);
        });

        //Element
        $this->app->bind(IAcgtModelFacade::class, function($app) {
            $this->app->when(AcgtModelFacade::class)->needs(BaseEloquent::class)->give(AcgtEloquent::class);

            return $app->make(AcgtModelFacade::class);
        });
        $this->app->bind(IAcztModelFacade::class, function($app) {
            $this->app->when(AcztModelFacade::class)->needs(BaseEloquent::class)->give(AcztEloquent::class);

            return $app->make(AcztModelFacade::class);
        });
        $this->app->bind(IAditModelFacade::class, function($app) {
            $this->app->when(AditModelFacade::class)->needs(BaseEloquent::class)->give(AditEloquent::class);

            return $app->make(AditModelFacade::class);
        });
        $this->app->bind(IAegtModelFacade::class, function($app) {
            $this->app->when(AegtModelFacade::class)->needs(BaseEloquent::class)->give(AegtEloquent::class);

            return $app->make(AegtModelFacade::class);
        });
        $this->app->bind(IAeztModelFacade::class, function($app) {
            $this->app->when(AeztModelFacade::class)->needs(BaseEloquent::class)->give(AeztEloquent::class);

            return $app->make(AeztModelFacade::class);
        });
        $this->app->bind(IAghtModelFacade::class, function($app) {
            $this->app->when(AghtModelFacade::class)->needs(BaseEloquent::class)->give(AghtEloquent::class);

            return $app->make(AghtModelFacade::class);
        });
        $this->app->bind(IAobtModelFacade::class, function($app) {
            $this->app->when(AobtModelFacade::class)->needs(BaseEloquent::class)->give(AobtEloquent::class);

            return $app->make(AobtModelFacade::class);
        });
        $this->app->bind(IArdtModelFacade::class, function($app) {
            $this->app->when(ArdtModelFacade::class)->needs(BaseEloquent::class)->give(ArdtEloquent::class);

            return $app->make(ArdtModelFacade::class);
        });
        $this->app->bind(IArztModelFacade::class, function($app) {
            $this->app->when(ArztModelFacade::class)->needs(BaseEloquent::class)->give(ArztEloquent::class);

            return $app->make(ArztModelFacade::class);
        });
        $this->app->bind(IAsbtModelFacade::class, function($app) {
            $this->app->when(AsbtModelFacade::class)->needs(BaseEloquent::class)->give(AsbtEloquent::class);

            return $app->make(AsbtModelFacade::class);
        });
        $this->app->bind(IAsrtModelFacade::class, function($app) {
            $this->app->when(AsrtModelFacade::class)->needs(BaseEloquent::class)->give(AsrtEloquent::class);

            return $app->make(AsrtModelFacade::class);
        });
        $this->app->bind(IAtetModelFacade::class, function($app) {
            $this->app->when(AtetModelFacade::class)->needs(BaseEloquent::class)->give(AtetEloquent::class);

            return $app->make(AtetModelFacade::class);
        });
        $this->app->bind(IAtotModelFacade::class, function($app) {
            $this->app->when(AtotModelFacade::class)->needs(BaseEloquent::class)->give(AtotEloquent::class);

            return $app->make(AtotModelFacade::class);
        });
        $this->app->bind(IAtstModelFacade::class, function($app) {
            $this->app->when(AtstModelFacade::class)->needs(BaseEloquent::class)->give(AtstEloquent::class);

            return $app->make(AtstModelFacade::class);
        });
        $this->app->bind(IAtttModelFacade::class, function($app) {
            $this->app->when(AtttModelFacade::class)->needs(BaseEloquent::class)->give(AtttEloquent::class);

            return $app->make(AtttModelFacade::class);
        });
        $this->app->bind(IAxotModelFacade::class, function($app) {
            $this->app->when(AxotModelFacade::class)->needs(BaseEloquent::class)->give(AxotEloquent::class);

            return $app->make(AxotModelFacade::class);
        });
        $this->app->bind(IAzatModelFacade::class, function($app) {
            $this->app->when(AzatModelFacade::class)->needs(BaseEloquent::class)->give(AzatEloquent::class);

            return $app->make(AzatModelFacade::class);
        });
        $this->app->bind(ICtotModelFacade::class, function($app) {
            $this->app->when(CtotModelFacade::class)->needs(BaseEloquent::class)->give(CtotEloquent::class);

            return $app->make(CtotModelFacade::class);
        });
        $this->app->bind(IEcztModelFacade::class, function($app) {
            $this->app->when(EcztModelFacade::class)->needs(BaseEloquent::class)->give(EcztEloquent::class);

            return $app->make(EcztModelFacade::class);
        });
        $this->app->bind(IEditModelFacade::class, function($app) {
            $this->app->when(EditModelFacade::class)->needs(BaseEloquent::class)->give(EditEloquent::class);

            return $app->make(EditModelFacade::class);
        });
        $this->app->bind(IEeztModelFacade::class, function($app) {
            $this->app->when(EeztModelFacade::class)->needs(BaseEloquent::class)->give(EeztEloquent::class);

            return $app->make(EeztModelFacade::class);
        });
        $this->app->bind(IEobtModelFacade::class, function($app) {
            $this->app->when(EobtModelFacade::class)->needs(BaseEloquent::class)->give(EobtEloquent::class);

            return $app->make(EobtModelFacade::class);
        });
        $this->app->bind(IErztModelFacade::class, function($app) {
            $this->app->when(ErztModelFacade::class)->needs(BaseEloquent::class)->give(ErztEloquent::class);

            return $app->make(ErztModelFacade::class);
        });
        $this->app->bind(IEtotModelFacade::class, function($app) {
            $this->app->when(EtotModelFacade::class)->needs(BaseEloquent::class)->give(EtotEloquent::class);

            return $app->make(EtotModelFacade::class);
        });
        $this->app->bind(IExotModelFacade::class, function($app) {
            $this->app->when(ExotModelFacade::class)->needs(BaseEloquent::class)->give(ExotEloquent::class);

            return $app->make(ExotModelFacade::class);
        });
        $this->app->bind(ISobtModelFacade::class, function($app) {
            $this->app->when(SobtModelFacade::class)->needs(BaseEloquent::class)->give(SobtEloquent::class);

            return $app->make(SobtModelFacade::class);
        });
        $this->app->bind(IStetModelFacade::class, function($app) {
            $this->app->when(StetModelFacade::class)->needs(BaseEloquent::class)->give(StetEloquent::class);

            return $app->make(StetModelFacade::class);
        });
        $this->app->bind(IStetModelFacade::class, function($app) {
            $this->app->when(StetModelFacade::class)->needs(BaseEloquent::class)->give(StetEloquent::class);

            return $app->make(StetModelFacade::class);
        });
        $this->app->bind(IStstModelFacade::class, function($app) {
            $this->app->when(StstModelFacade::class)->needs(BaseEloquent::class)->give(StstEloquent::class);

            return $app->make(StstModelFacade::class);
        });
        $this->app->bind(ITobtModelFacade::class, function($app) {
            $this->app->when(TobtModelFacade::class)->needs(BaseEloquent::class)->give(TobtEloquent::class);

            return $app->make(TobtModelFacade::class);
        });
        $this->app->bind(ITsatModelFacade::class, function($app) {
            $this->app->when(TsatModelFacade::class)->needs(BaseEloquent::class)->give(TsatEloquent::class);

            return $app->make(TsatModelFacade::class);
        });
        $this->app->bind(ITtotModelFacade::class, function($app) {
            $this->app->when(TtotModelFacade::class)->needs(BaseEloquent::class)->give(TtotEloquent::class);

            return $app->make(TtotModelFacade::class);
        });
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
