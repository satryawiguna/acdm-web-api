<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register/{group}', 'Api\Auth\RegisterController@actionRegister');
Route::post('/login', 'Api\Auth\LoginController@actionLogin');
Route::post('/logout', 'Api\Auth\LogoutController@actionLogout');
Route::post('/refresh-token', 'Api\Auth\LoginController@actionRefreshToken');
Route::get('/unauthorized', 'Api\Auth\LoginController@actionUnauthorized');
Route::post('/check-password', 'Api\Auth\LoginController@actionCheckPassword');

Route::group(['middleware' => ['check.client.credentials', 'auth:api', 'check.timezone']], function () {
    //<editor-fold desc="#system region">
    Route::group(['middleware' => 'permission:manage-system'], function () {
        Route::prefix('/system')->group(function () {
            //<editor-fold desc="#group region">
            Route::group(['middleware' => 'permission:manage-group'], function () {
                Route::get('/groups', 'Api\System\GroupController@actionGetGroups')->middleware(['access:manage-group,get']);
                Route::post('/groups/list-search', 'Api\System\GroupController@actionGetGroupsListSearch')->middleware(['access:manage-group,post']);
                Route::post('/groups/page-search', 'Api\System\GroupController@actionGetGroupsPageSearch')->middleware(['access:manage-group,post']);
                Route::post('/group', 'Api\System\GroupController@actionCreateGroup')->middleware(['access:manage-group,post']);
                Route::get('/group/{id}', 'Api\System\GroupController@actionShowGroup')->middleware(['access:manage-group,get']);
                Route::put('/group/{id}', 'Api\System\GroupController@actionUpdateGroup')->middleware(['access:manage-group,put']);
                Route::delete('/group/{id}', 'Api\System\GroupController@actionDestroyGroup')->middleware(['access:manage-group,delete']);
                Route::delete('/groups', 'Api\System\GroupController@actionDestroyGroups')->middleware(['access:manage-group,delete']);
                Route::get('/group/slug/{name}', 'Api\System\GroupController@actiongetSlugGroup')->middleware(['access:manage-group,*']);
            });
            //</editor-fold>
            //<editor-fold desc="#role region">
            Route::group(['middleware' => 'permission:manage-role'], function () {
                Route::get('/roles', 'Api\System\RoleController@actionGetRoles')->middleware(['access:manage-role,get']);
                Route::post('/roles/list-search', 'Api\System\RoleController@actionGetRolesListSearch')->middleware(['access:manage-role,post']);
                Route::post('/roles/page-search', 'Api\System\RoleController@actionGetRolesPageSearch')->middleware(['access:manage-role,post']);
                Route::post('/role', 'Api\System\RoleController@actionCreateRole')->middleware(['access:manage-role,post']);
                Route::get('/role/{id}', 'Api\System\RoleController@actionShowRole')->middleware(['access:manage-role,get']);
                Route::put('/role/{id}', 'Api\System\RoleController@actionUpdateRole')->middleware(['access:manage-role,put']);
                Route::delete('/role/{id}', 'Api\System\RoleController@actionDestroyRole')->middleware(['access:manage-role,delete']);
                Route::delete('/roles', 'Api\System\RoleController@actionDestroyRoles')->middleware(['access:manage-role,delete']);
                Route::get('/role/slug/{name}', 'Api\System\RoleController@actiongetSlugRole')->middleware(['access:manage-role,*']);

                Route::prefix('/role/{id}')->group(function () {
                    Route::get('/permissions', 'Api\System\RoleController@actionGetRolePermissions')->middleware(['access:manage-role|manage-permission,get']);
                    Route::post('/permissions', 'Api\System\RoleController@actionSyncRolePermissions')->middleware(['access:manage-role|manage-permission,post']);
                });
            });
            //</editor-fold>
            //<editor-fold desc="#permission region">
            Route::group(['middleware' => 'permission:manage-permission'], function () {
                Route::get('/permissions', 'Api\System\PermissionController@actionGetPermissions')->middleware(['access:manage-permission,get']);
                Route::post('/permissions/list-search', 'Api\System\PermissionController@actionGetPermissionsListSearch')->middleware(['access:manage-permission,post']);
                Route::post('/permissions/page-search', 'Api\System\PermissionController@actionGetPermissionsPageSearch')->middleware(['access:manage-permission,post']);
                Route::post('/permission', 'Api\System\PermissionController@actionCreatePermission')->middleware(['access:manage-permission,post']);
                Route::get('/permission/{id}', 'Api\System\PermissionController@actionShowPermission')->middleware(['access:manage-permission,get']);
                Route::put('/permission/{id}', 'Api\System\PermissionController@actionUpdatePermission')->middleware(['access:manage-permission,put']);
                Route::delete('/permission/{id}', 'Api\System\PermissionController@actionDestroyPermission')->middleware(['access:manage-permission,delete']);
                Route::delete('/permissions', 'Api\System\PermissionController@actionDestroyPermissions')->middleware(['access:manage-permission,delete']);
                Route::get('/permission/slug/{name}', 'Api\System\PermissionController@actiongetSlugPermission')->middleware(['access:manage-permission,*']);

                Route::prefix('/permission/{id}')->group(function () {
                    Route::get('/accesses', 'Api\System\PermissionController@actionGetPermissionAccesses')->middleware(['access:manage-permission|manage-access,get']);
                    Route::post('/accesses', 'Api\System\PermissionController@actionSyncPermissionAccesses')->middleware(['access:manage-permission|manage-access,post']);
                });
            });
            //</editor-fold>
            //<editor-fold desc="#access region">
            Route::group(['middleware' => 'permission:manage-access'], function () {
                Route::get('/accesses', 'Api\System\AccessController@actionGetAccesses')->middleware(['access:manage-access,get']);
                Route::post('/accesses/list-search', 'Api\System\AccessController@actionGetAccessesListSearch')->middleware(['access:manage-access,post']);
                Route::post('/accesses/page-search', 'Api\System\AccessController@actionGetAccessesPageSearch')->middleware(['access:manage-access,post']);
                Route::post('/access', 'Api\System\AccessController@actionCreateAccess')->middleware(['access:manage-access,post']);
                Route::get('/access/{id}', 'Api\System\AccessController@actionShowAccess')->middleware(['access:manage-access,get']);
                Route::put('/access/{id}', 'Api\System\AccessController@actionUpdateAccess')->middleware(['access:manage-access,put']);
                Route::delete('/access/{id}', 'Api\System\AccessController@actionDestroyAccess')->middleware(['access:manage-access,delete']);
                Route::delete('/accesses', 'Api\System\AccessController@actionDestroyAccesses')->middleware(['access:manage-access,delete']);
                Route::get('/access/slug/{name}', 'Api\System\AccessController@actiongetSlugAccess')->middleware(['access:manage-access,*']);
            });
            //</editor-fold>
        });
    });
    //</editor-fold>


    //<editor-fold desc="#membership region">
    Route::group(['middleware' => 'permission:manage-membership|*'], function () {
        Route::prefix('/membership')->group(function () {
            //<editor-fold desc="#user region">
            Route::group(['middleware' => 'permission:manage-user|*'], function () {
                Route::get('/users', 'Api\Membership\UserController@actionGetUsers')->middleware(['access:manage-user,get']);
                Route::get('/users-group-by-role', 'Api\Membership\UserController@actionGetUsersGroupByRole')->middleware(['access:manage-user,get']);
                Route::post('/users/list-search', 'Api\Membership\UserController@actionGetUsersListSearch')->middleware(['access:manage-user,post']);
                Route::post('/users/page-search', 'Api\Membership\UserController@actionGetUsersPageSearch')->middleware(['access:manage-user,post']);
                Route::get('/user/{id}', 'Api\Membership\UserController@actionShowUser')->middleware(['access:manage-user,get']);
                Route::delete('/user/{id}', 'Api\Membership\UserController@actionDestroyUser')->middleware(['access:manage-user,delete']);
                Route::delete('/users', 'Api\Membership\UserController@actionDestroyUsers')->middleware(['access:manage-user,delete']);

                Route::prefix('/user')->group(function () {
                    Route::get('/profile/me', 'Api\Membership\UserController@actionGetUserProfileMe')->middleware(['access:manage-user|manage-profile|*,get']);
                    Route::put('/profile/me', 'Api\Membership\UserController@actionUpdateUserProfileMe')->middleware(['access:manage-user|manage-profile|*,put']);

                    Route::get('/profile/{userId}', 'Api\Membership\UserController@actionGetUserProfile')->middleware(['access:manage-user|manage-profile|*,get']);
                    Route::put('/profile/{userId}', 'Api\Membership\UserController@actionUpdateUserProfile')->middleware(['access:manage-user|manage-profile|*,put']);
                });

                Route::prefix('/user/{id}')->group(function () {
                    Route::get('/group', 'Api\Membership\UserController@actionGetUserGroup')->middleware(['access:manage-user|manage-group,get']);
                    Route::put('/group', 'Api\Membership\UserController@actionUpdateUserGroup')->middleware(['access:manage-user|manage-group,post']);

                    Route::get('/roles', 'Api\Membership\UserController@actionGetUserRoles')->middleware(['access:manage-user|manage-role,get']);
                    Route::put('/roles', 'Api\Membership\UserController@actionUpdateUserRoles')->middleware(['access:manage-user|manage-role,post']);

                    Route::get('/permissions', 'Api\Membership\UserController@actionGetUserPermissions')->middleware(['access:manage-user|manage-permission,get']);
                    Route::put('/permissions', 'Api\Membership\UserController@actionUpdateUserPermissions')->middleware(['access:manage-user|manage-permission,post']);

                    Route::prefix('/permission/{permission_id}')->group(function () {
                        Route::get('/accesses', 'Api\Membership\UserController@actionGetUserAccesses')->middleware(['access:manage-user|manage-access,get']);
                        Route::put('/accesses', 'Api\Membership\UserController@actionUpdateUserAccesses')->middleware(['access:manage-user|manage-access,post']);
                    });
                });
            });
            //</editor-fold>
        });
    });
    //</editor-fold>


    //<editor-fold desc="#master data region">
    Route::group(['middleware' => 'permission:manage-master-data|*'], function () {
        Route::prefix('/master-data')->group(function () {
            //<editor-fold desc="#airport region">
            Route::group(['middleware' => 'permission:manage-airport|*'], function () {
                Route::get('/airports', 'Api\MasterData\AirportController@actionGetAirports')->middleware(['access:manage-airport|*,get']);
                Route::post('/airports/list-search', 'Api\MasterData\AirportController@actionGetAirportsListSearch')->middleware(['access:manage-airport|*,post']);
                Route::post('/airports/page-search', 'Api\MasterData\AirportController@actionGetAirportsPageSearch')->middleware(['access:manage-airport|*,post']);
                Route::post('/airport', 'Api\MasterData\AirportController@actionCreateAirport')->middleware(['access:manage-airport|*,post']);
                Route::post('/airports', 'Api\MasterData\AirportController@actionCreateAirports')->middleware(['access:manage-airport|*,post']);
                Route::get('/airport/{id}', 'Api\MasterData\AirportController@actionShowAirport')->middleware(['access:manage-airport|*,get']);
                Route::get('/airport/iata/{code}', 'Api\MasterData\AirportController@actionShowAirportByIata')->middleware(['access:manage-airport|*,get']);
                Route::get('/airport/icao/{code}', 'Api\MasterData\AirportController@actionShowAirportByIcao')->middleware(['access:manage-airport|*,get']);
                Route::put('/airport/{id}', 'Api\MasterData\AirportController@actionUpdateAirport')->middleware(['access:manage-airport|*,put']);
                Route::delete('/airport/{id}', 'Api\MasterData\AirportController@actionDestroyAirport')->middleware(['access:manage-airport|*,delete']);
                Route::delete('/airports', 'Api\MasterData\AirportController@actionDestroyAirports')->middleware(['access:manage-airport|*,delete']);
                Route::get('/airport/slug/{name}', 'Api\MasterData\AirportController@actiongetSlugAirport')->middleware(['access:manage-airport,*']);
            });
            //</editor-fold>

            //<editor-fold desc="#airline region">
            Route::group(['middleware' => 'permission:manage-airline|*'], function () {
                Route::get('/airlines', 'Api\MasterData\AirlineController@actionGetAirlines')->middleware(['access:manage-airline|*,get']);
                Route::post('/airlines/list-search', 'Api\MasterData\AirlineController@actionGetAirlinesListSearch')->middleware(['access:manage-airline|*,post']);
                Route::post('/airlines/page-search', 'Api\MasterData\AirlineController@actionGetAirlinesPageSearch')->middleware(['access:manage-airline|*,post']);
                Route::post('/airline', 'Api\MasterData\AirlineController@actionCreateAirline')->middleware(['access:manage-airline|*,post']);
                Route::get('/airline/{id}', 'Api\MasterData\AirlineController@actionShowAirline')->middleware(['access:manage-airline|*,get']);
                Route::put('/airline/{id}', 'Api\MasterData\AirlineController@actionUpdateAirline')->middleware(['access:manage-airline|*,put']);
                Route::delete('/airline/{id}', 'Api\MasterData\AirlineController@actionDestroyAirline')->middleware(['access:manage-airline|*,delete']);
                Route::delete('/airlines', 'Api\MasterData\AirlineController@actionDestroyAirlines')->middleware(['access:manage-airline|*,delete']);
                Route::get('/airline/slug/{name}', 'Api\MasterData\AirlineController@actiongetSlugAirline')->middleware(['access:manage-airline,*']);
            });
            //</editor-fold>

            //<editor-fold desc="#vendor region">
            Route::group(['middleware' => 'permission:manage-vendor|*'], function () {
                Route::get('/vendors', 'Api\MasterData\VendorController@actionGetVendors')->middleware(['access:manage-vendor|*,get']);
                Route::post('/vendors/list-search', 'Api\MasterData\VendorController@actionGetVendorsListSearch')->middleware(['access:manage-vendor|*,post']);
                Route::post('/vendors/page-search', 'Api\MasterData\VendorController@actionGetVendorsPageSearch')->middleware(['access:manage-vendor|*,post']);
                Route::post('/vendor', 'Api\MasterData\VendorController@actionCreateVendor')->middleware(['access:manage-vendor|*,post']);
                Route::post('/vendors', 'Api\MasterData\VendorController@actionCreateVendors')->middleware(['access:manage-vendor|*,post']);
                Route::get('/vendor/{id}', 'Api\MasterData\VendorController@actionShowVendor')->middleware(['access:manage-vendor|*,get']);
                Route::put('/vendor/{id}', 'Api\MasterData\VendorController@actionUpdateVendor')->middleware(['access:manage-vendor|*,put']);
                Route::delete('/vendor/{id}', 'Api\MasterData\VendorController@actionDestroyVendor')->middleware(['access:manage-vendor|*,delete']);
                Route::delete('/vendors', 'Api\MasterData\VendorController@actionDestroyVendors')->middleware(['access:manage-vendor|*,delete']);
                Route::get('/vendor/slug/{name}', 'Api\MasterData\VendorController@actiongetSlugVendor')->middleware(['access:manage-vendor,*']);
            });
            //</editor-fold>

            //<editor-fold desc="#country region">
            Route::group(['middleware' => 'permission:manage-country|*'], function () {
                Route::get('/countries', 'Api\MasterData\CountryController@actionGetCountries')->middleware(['access:manage-country|*,get']);
                Route::post('/countries/list-search', 'Api\MasterData\CountryController@actionGetCountriesListSearch')->middleware(['access:manage-country|*,post']);
                Route::post('/countries/page-search', 'Api\MasterData\CountryController@actionGetCountriesPageSearch')->middleware(['access:manage-country|*,post']);
                Route::post('/country', 'Api\MasterData\CountryController@actionCreateCountry')->middleware(['access:manage-country|*,post']);
                Route::get('/country/{id}', 'Api\MasterData\CountryController@actionShowCountry')->middleware(['access:manage-country|*,get']);
                Route::put('/country/{id}', 'Api\MasterData\CountryController@actionUpdateCountry')->middleware(['access:manage-country|*,put']);
                Route::delete('/country/{id}', 'Api\MasterData\CountryController@actionDestroyCountry')->middleware(['access:manage-country|*,delete']);
                Route::get('/country/slug/{name}', 'Api\MasterData\CountryController@actiongetSlugCountry')->middleware(['access:manage-country,*']);
            });
            //</editor-fold>

            //<editor-fold desc="#organization region">
            Route::group(['middleware' => 'permission:manage-country|*'], function () {
                Route::get('/organizations', 'Api\MasterData\OrganizationController@actionGetOrganizations')->middleware(['access:manage-organization|*,get']);
                Route::post('/organizations/list-search', 'Api\MasterData\OrganizationController@actionGetOrganizationsListSearch')->middleware(['access:manage-organization|*,post']);
                Route::post('/organizations/page-search', 'Api\MasterData\OrganizationController@actionGetOrganizationsPageSearch')->middleware(['access:manage-organization|*,post']);
                Route::post('/organization', 'Api\MasterData\OrganizationController@actionCreateOrganization')->middleware(['access:manage-organization|*,post']);
                Route::get('/organization/{id}', 'Api\MasterData\OrganizationController@actionShowOrganization')->middleware(['access:manage-organization|*,get']);
                Route::put('/organization/{id}', 'Api\MasterData\OrganizationController@actionUpdateOrganization')->middleware(['access:manage-organization|*,put']);
                Route::delete('/organization/{id}', 'Api\MasterData\OrganizationController@actionDestroyOrganization')->middleware(['access:manage-organization|*,delete']);
                Route::get('/organization/slug/{name}', 'Api\MasterData\OrganizationController@actiongetSlugOrganization')->middleware(['access:manage-organization,*']);
            });
            //</editor-fold>
        });
    });
    //</editor-fold>


    //<editor-fold desc="#departure region">
    Route::group(['middleware' => 'permission:*'], function () {
        Route::get('/departure/{id}', 'Api\Departure\DepartureController@actionShowDeparture')->middleware(['access:*,*']);
        Route::get('/departure/aodb/{id}', 'Api\Departure\DepartureController@actionShowDepartureByAodbId')->middleware(['access:*,*']);
        Route::post('/departures/list-search', 'Api\Departure\DepartureController@actionGetDeparturesListSearch')->middleware(['access:*,*']);
        Route::post('/departures/page-search', 'Api\Departure\DepartureController@actionGetDeparturesPageSearch')->middleware(['access:*,*']);
        Route::post('/departures/tobt-updated', 'Api\Departure\DepartureController@actionGetDeparturesTobtUpdated')->middleware(['access:*,*']);

        Route::post('/departures/ids', 'Api\Departure\DepartureController@actionGetDeparturesByIds')->middleware(['access:*,*']);
        Route::prefix('/departures')->group(function () {
            Route::post('/aodb/ids', 'Api\Departure\DepartureController@actionGetDeparturesByAodbIds')->middleware(['access:*,*']);
        });

        Route::post('/departure', 'Api\Departure\DepartureController@actionCreateDeparture')->middleware(['access:*,*']);
        Route::post('/departures', 'Api\Departure\DepartureController@actionCreateDepartures')->middleware(['access:*,*']);

        Route::put('/departure/{id}', 'Api\Departure\DepartureController@actionUpdateDeparture')->middleware(['access:*,*']);
        Route::put('/departures', 'Api\Departure\DepartureController@actionUpdateDepartures')->middleware(['access:*,*']);
        Route::put('/departure/aodb/{id}', 'Api\Departure\DepartureController@actionUpdateDepartureByAodbId')->middleware(['access:*,*']);
        Route::put('/departures/aodb', 'Api\Departure\DepartureController@actionUpdateDeparturesByAodbIds')->middleware(['access:*,*']);

        Route::prefix('/history')->group(function () {
            Route::post('/departures/list-search', 'Api\Departure\DepartureController@actionGetHistoryDeparturesListSearch')->middleware(['access:*,*']);
            Route::post('/departures/page-search', 'Api\Departure\DepartureController@actionGetHistoryDeparturesPageSearch')->middleware(['access:*,*']);
        });
    });
    //</editor-fold>


    //<editor-fold desc="#flight information region">
    Route::group(['middleware' => 'permission:*'], function () {
        Route::get('/flight-information/{departureId}/latest', 'Api\Departure\FlightInformationController@actionGetLatestFlightInformation')->middleware(['access:*,*']);
        Route::post('/flight-information', 'Api\Departure\FlightInformationController@actionCreateFlightInformation')->middleware(['access:*,*']);
    });
    //</editor-fold>


    //<editor-fold desc="#element region">
    Route::group(['middleware' => 'permission:*'], function () {
        Route::get('/element/{departureId}/acgts', 'Api\Element\ElementController@actionGetAcgts')->middleware(['access:*,*']);
        Route::post('/element/acgt', 'Api\Element\ElementController@actionCreateAcgt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/aczts', 'Api\Element\ElementController@actionGetAcgts')->middleware(['access:*,*']);
        Route::post('/element/aczt', 'Api\Element\ElementController@actionCreateAczt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/adits', 'Api\Element\ElementController@actionGetAdits')->middleware(['access:*,*']);
        Route::post('/element/adit', 'Api\Element\ElementController@actionCreateAdit')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/aegts', 'Api\Element\ElementController@actionGetAegts')->middleware(['access:*,*']);
        Route::post('/element/aegt', 'Api\Element\ElementController@actionCreateAegt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/aezts', 'Api\Element\ElementController@actionGetAezts')->middleware(['access:*,*']);
        Route::post('/element/aezt', 'Api\Element\ElementController@actionCreateAezt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/aghts', 'Api\Element\ElementController@actionGetAghts')->middleware(['access:*,*']);
        Route::post('/element/aght', 'Api\Element\ElementController@actionCreateAght')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/aobts', 'Api\Element\ElementController@actionGetAobts')->middleware(['access:*,*']);
        Route::post('/element/aobt', 'Api\Element\ElementController@actionCreateAobt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/ardts', 'Api\Element\ElementController@actionGetArdts')->middleware(['access:*,*']);
        Route::post('/element/ardt', 'Api\Element\ElementController@actionCreateArdt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/arzts', 'Api\Element\ElementController@actionGetArzts')->middleware(['access:*,*']);
        Route::post('/element/arzt', 'Api\Element\ElementController@actionCreateArzt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/asbts', 'Api\Element\ElementController@actionGetAsbts')->middleware(['access:*,*']);
        Route::post('/element/asbt', 'Api\Element\ElementController@actionCreateAsbt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/asrts', 'Api\Element\ElementController@actionGetAsrts')->middleware(['access:*,*']);
        Route::post('/element/asrt', 'Api\Element\ElementController@actionCreateAsrt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/atets', 'Api\Element\ElementController@actionGetAtets')->middleware(['access:*,*']);
        Route::post('/element/atet', 'Api\Element\ElementController@actionCreateAtet')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/atots', 'Api\Element\ElementController@actionGetAtots')->middleware(['access:*,*']);
        Route::post('/element/atot', 'Api\Element\ElementController@actionCreateAtot')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/atsts', 'Api\Element\ElementController@actionGetAtsts')->middleware(['access:*,*']);
        Route::post('/element/atst', 'Api\Element\ElementController@actionCreateAtst')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/attts', 'Api\Element\ElementController@actionGetAttts')->middleware(['access:*,*']);
        Route::post('/element/attt', 'Api\Element\ElementController@actionCreateAttt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/axots', 'Api\Element\ElementController@actionGetAxots')->middleware(['access:*,*']);
        Route::post('/element/axot', 'Api\Element\ElementController@actionCreateAxot')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/azats', 'Api\Element\ElementController@actionGetAzats')->middleware(['access:*,*']);
        Route::post('/element/azat', 'Api\Element\ElementController@actionCreateAzat')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/ctots', 'Api\Element\ElementController@actionGetCtots')->middleware(['access:*,*']);
        Route::post('/element/ctot', 'Api\Element\ElementController@actionCreateCtot')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/eczts', 'Api\Element\ElementController@actionGetEczts')->middleware(['access:*,*']);
        Route::post('/element/eczt', 'Api\Element\ElementController@actionCreateEczt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/edits', 'Api\Element\ElementController@actionGetEdits')->middleware(['access:*,*']);
        Route::post('/element/edit', 'Api\Element\ElementController@actionCreateEdit')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/eezts', 'Api\Element\ElementController@actionGetEezts')->middleware(['access:*,*']);
        Route::post('/element/eezt', 'Api\Element\ElementController@actionCreateEezt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/eobts', 'Api\Element\ElementController@actionGetEobts')->middleware(['access:*,*']);
        Route::post('/element/eobt', 'Api\Element\ElementController@actionCreateEobt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/erzts', 'Api\Element\ElementController@actionGetErzts')->middleware(['access:*,*']);
        Route::post('/element/erzt', 'Api\Element\ElementController@actionCreateErzt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/etots', 'Api\Element\ElementController@actionGetEtots')->middleware(['access:*,*']);
        Route::post('/element/etot', 'Api\Element\ElementController@actionCreateEtot')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/exots', 'Api\Element\ElementController@actionGetExots')->middleware(['access:*,*']);
        Route::post('/element/exot', 'Api\Element\ElementController@actionCreateExot')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/sobts', 'Api\Element\ElementController@actionGetSobts')->middleware(['access:*,*']);
        Route::post('/element/sobt', 'Api\Element\ElementController@actionCreateSobt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/stets', 'Api\Element\ElementController@actionGetStets')->middleware(['access:*,*']);
        Route::post('/element/stet', 'Api\Element\ElementController@actionCreateStet')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/ststs', 'Api\Element\ElementController@actionGetStsts')->middleware(['access:*,*']);
        Route::post('/element/stst', 'Api\Element\ElementController@actionCreateStst')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/tobts', 'Api\Element\ElementController@actionGetTobts')->middleware(['access:*,*']);
        Route::post('/element/tobt', 'Api\Element\ElementController@actionCreateTobt')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/tsats', 'Api\Element\ElementController@actionGetTsats')->middleware(['access:*,*']);
        Route::post('/element/tsat', 'Api\Element\ElementController@actionCreateTsat')->middleware(['access:*,*']);

        Route::get('/element/{departureId}/ttots', 'Api\Element\ElementController@actionGetTtots')->middleware(['access:*,*']);
        Route::post('/element/ttot', 'Api\Element\ElementController@actionCreateTtot')->middleware(['access:*,*']);
    });
    //</editor-fold>


    //<editor-fold desc="#media region">
    Route::group(['middleware' => 'permission:*'], function () {
        Route::post('/media/file-upload', 'Api\Media\MediaController@actionFileUpload')->middleware(['access:manage-media|*,post']);
        Route::post('/media/file-uploads', 'Api\Media\MediaController@actionFileUploads')->middleware(['access:manage-media|*,post']);
        Route::get('/medias', 'Api\Media\MediaController@actionGetMedias')->middleware(['access:manage-media|*,get']);
        Route::post('/medias/list-search', 'Api\Media\MediaController@actionGetMediasListSearch')->middleware(['access:manage-media|*,post']);
        Route::post('/medias/page-search', 'Api\Media\MediaController@actionGetMediasPageSearch')->middleware(['access:manage-media|*,post']);
        Route::get('/media/{id}', 'Api\Media\MediaController@actionShowMedia')->middleware(['access:manage-media|*,get']);
        Route::delete('/media/{id}', 'Api\Media\MediaController@actionDestroyMedia')->middleware(['access:manage-media|*,delete']);
        Route::delete('/medias', 'Api\Media\MediaController@actionDestroyMedias')->middleware(['access:manage-media|*,delete']);
    });
    //</editor-fold>
});
