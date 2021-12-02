<?php
namespace App\Presentation\Http\Providers;


use App\Domain\Contracts\Depature\IDepartureMetaRepository;
use App\Domain\Contracts\Depature\IDepartureRepository;
use App\Domain\Contracts\Depature\IFlightInformationRepository;
use App\Domain\Contracts\Element\AcgtRepository;
use App\Domain\Contracts\Element\AcztRepository;
use App\Domain\Contracts\Element\AditRepository;
use App\Domain\Contracts\Element\AegtRepository;
use App\Domain\Contracts\Element\AeztRepository;
use App\Domain\Contracts\Element\AghtRepository;
use App\Domain\Contracts\Element\AobtRepository;
use App\Domain\Contracts\Element\ArdtRepository;
use App\Domain\Contracts\Element\ArztRepository;
use App\Domain\Contracts\Element\AsbtRepository;
use App\Domain\Contracts\Element\AsrtRepository;
use App\Domain\Contracts\Element\AtetRepository;
use App\Domain\Contracts\Element\AtotRepository;
use App\Domain\Contracts\Element\AtstRepository;
use App\Domain\Contracts\Element\AtttRepository;
use App\Domain\Contracts\Element\AxotRepository;
use App\Domain\Contracts\Element\AzatRepository;
use App\Domain\Contracts\Element\CtotRepository;
use App\Domain\Contracts\Element\EcztRepository;
use App\Domain\Contracts\Element\EditRepository;
use App\Domain\Contracts\Element\EeztRepository;
use App\Domain\Contracts\Element\EobtRepository;
use App\Domain\Contracts\Element\ErztRepository;
use App\Domain\Contracts\Element\EtotRepository;
use App\Domain\Contracts\Element\ExotRepository;
use App\Domain\Contracts\Element\IAcgtRepository;
use App\Domain\Contracts\Element\IAcztRepository;
use App\Domain\Contracts\Element\IAditRepository;
use App\Domain\Contracts\Element\IAegtRepository;
use App\Domain\Contracts\Element\IAeztRepository;
use App\Domain\Contracts\Element\IAghtRepository;
use App\Domain\Contracts\Element\IAobtRepository;
use App\Domain\Contracts\Element\IArdtRepository;
use App\Domain\Contracts\Element\IArztRepository;
use App\Domain\Contracts\Element\IAsbtRepository;
use App\Domain\Contracts\Element\IAsrtRepository;
use App\Domain\Contracts\Element\IAtetRepository;
use App\Domain\Contracts\Element\IAtotRepository;
use App\Domain\Contracts\Element\IAtstRepository;
use App\Domain\Contracts\Element\IAtttRepository;
use App\Domain\Contracts\Element\IAxotRepository;
use App\Domain\Contracts\Element\IAzatRepository;
use App\Domain\Contracts\Element\ICtotRepository;
use App\Domain\Contracts\Element\IEcztRepository;
use App\Domain\Contracts\Element\IEditRepository;
use App\Domain\Contracts\Element\IEeztRepository;
use App\Domain\Contracts\Element\IEobtRepository;
use App\Domain\Contracts\Element\IErztRepository;
use App\Domain\Contracts\Element\IEtotRepository;
use App\Domain\Contracts\Element\IExotRepository;
use App\Domain\Contracts\Element\ISobtRepository;
use App\Domain\Contracts\Element\IStetRepository;
use App\Domain\Contracts\Element\IStstRepository;
use App\Domain\Contracts\Element\ITobtRepository;
use App\Domain\Contracts\Element\ITsatRepository;
use App\Domain\Contracts\Element\ITtotRepository;
use App\Domain\Contracts\Element\SobtRepository;
use App\Domain\Contracts\Element\StetRepository;
use App\Domain\Contracts\Element\StstRepository;
use App\Domain\Contracts\Element\TsatRepository;
use App\Domain\Contracts\Element\TtotRepository;
use App\Domain\Contracts\MasterData\IAirlineRepository;
use App\Domain\Contracts\MasterData\ICountryRepository;
use App\Domain\Contracts\MasterData\IOrganizationRepository;
use App\Domain\Contracts\MasterData\IVendorRepository;
use App\Domain\Contracts\Media\IMediaRepository;
use App\Domain\Contracts\Membership\IUserRepository;
use App\Domain\Contracts\MasterData\IAirportRepository;
use App\Domain\Contracts\Membership\IProfileRepository;
use App\Domain\Contracts\System\IPermissionRepository;
use App\Domain\Contracts\System\IRoleRepository;
use App\Domain\Contracts\System\IAccessRepository;
use App\Domain\Contracts\System\IGroupRepository;
use App\Infrastructure\Persistence\Repositories\Departure\DepartureMetaRepository;
use App\Infrastructure\Persistence\Repositories\Departure\DepartureRepository;
use App\Infrastructure\Persistence\Repositories\Departure\FlightInformationRepository;
use App\Infrastructure\Persistence\Repositories\Element\TobtRepository;
use App\Infrastructure\Persistence\Repositories\MasterData\AirlineRepository;
use App\Infrastructure\Persistence\Repositories\MasterData\AirportRepository;
use App\Infrastructure\Persistence\Repositories\MasterData\CountryRepository;
use App\Infrastructure\Persistence\Repositories\MasterData\OrganizationRepository;
use App\Infrastructure\Persistence\Repositories\MasterData\VendorRepository;
use App\Infrastructure\Persistence\Repositories\Media\MediaRepository;
use App\Infrastructure\Persistence\Repositories\Membership\UserRepository;
use App\Infrastructure\Persistence\Repositories\Membership\ProfileRepository;
use App\Infrastructure\Persistence\Repositories\System\AccessRepository;
use App\Infrastructure\Persistence\Repositories\System\GroupRepository;
use App\Infrastructure\Persistence\Repositories\System\PermissionRepository;
use App\Infrastructure\Persistence\Repositories\System\RoleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //System
        $this->app->bind(IGroupRepository::class, GroupRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
        $this->app->bind(IPermissionRepository::class, PermissionRepository::class);
        $this->app->bind(IAccessRepository::class, AccessRepository::class);


        //Membership
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IProfileRepository::class, ProfileRepository::class);


        //Media
        $this->app->bind(IMediaRepository::class, MediaRepository::class);


        //Master Data
        $this->app->bind(IAirportRepository::class, AirportRepository::class);
        $this->app->bind(IAirlineRepository::class, AirlineRepository::class);
        $this->app->bind(IVendorRepository::class, VendorRepository::class);
        $this->app->bind(ICountryRepository::class, CountryRepository::class);
        $this->app->bind(IOrganizationRepository::class, OrganizationRepository::class);


        //Departure
        $this->app->bind(IDepartureRepository::class, DepartureRepository::class);
        $this->app->bind(IDepartureMetaRepository::class, DepartureMetaRepository::class);
        $this->app->bind(IFlightInformationRepository::class, FlightInformationRepository::class);


        //Element
        $this->app->bind(IAcgtRepository::class, AcgtRepository::class);
        $this->app->bind(IAcztRepository::class, AcztRepository::class);
        $this->app->bind(IAditRepository::class, AditRepository::class);
        $this->app->bind(IAegtRepository::class, AegtRepository::class);
        $this->app->bind(IAeztRepository::class, AeztRepository::class);
        $this->app->bind(IAghtRepository::class, AghtRepository::class);
        $this->app->bind(IAobtRepository::class, AobtRepository::class);
        $this->app->bind(IArdtRepository::class, ArdtRepository::class);
        $this->app->bind(IArztRepository::class, ArztRepository::class);
        $this->app->bind(IAsbtRepository::class, AsbtRepository::class);
        $this->app->bind(IAsrtRepository::class, AsrtRepository::class);
        $this->app->bind(IAtetRepository::class, AtetRepository::class);
        $this->app->bind(IAtotRepository::class, AtotRepository::class);
        $this->app->bind(IAtstRepository::class, AtstRepository::class);
        $this->app->bind(IAtttRepository::class, AtttRepository::class);
        $this->app->bind(IAxotRepository::class, AxotRepository::class);
        $this->app->bind(IAzatRepository::class, AzatRepository::class);
        $this->app->bind(ICtotRepository::class, CtotRepository::class);
        $this->app->bind(IEcztRepository::class, EcztRepository::class);
        $this->app->bind(IEditRepository::class, EditRepository::class);
        $this->app->bind(IEeztRepository::class, EeztRepository::class);
        $this->app->bind(IEobtRepository::class, EobtRepository::class);
        $this->app->bind(IErztRepository::class, ErztRepository::class);
        $this->app->bind(IEtotRepository::class, EtotRepository::class);
        $this->app->bind(IExotRepository::class, ExotRepository::class);
        $this->app->bind(ISobtRepository::class, SobtRepository::class);
        $this->app->bind(IStetRepository::class, StetRepository::class);
        $this->app->bind(IStstRepository::class, StstRepository::class);
        $this->app->bind(ITobtRepository::class, TobtRepository::class);
        $this->app->bind(ITsatRepository::class, TsatRepository::class);
        $this->app->bind(ITtotRepository::class, TtotRepository::class);
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
