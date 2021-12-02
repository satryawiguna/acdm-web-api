<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        ini_set('memory_limit','512M');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        //Element (Dummy Data)
//        DB::table('sobts')->truncate();
//        DB::table('tobts')->truncate();

        //Departure (Dummy Data)
//        DB::table('departures')->truncate();
//        DB::table('departure_metas')->truncate();

        //Profile
        DB::table('profiles')->truncate();

        //Membership
        DB::table('permission_accesses')->truncate();
        DB::table('role_permissions')->truncate();
        DB::table('user_roles')->truncate();
        DB::table('user_groups')->truncate();
        DB::table('users')->truncate();
        DB::table('accesses')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('groups')->truncate();

        //Master Data (Dummy Data)
        DB::table('airports')->truncate();
        DB::table('vendors')->truncate();
        DB::table('countries')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //Master Data (Dummy Data)
        $this->call(AirportSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(CountrySeeder::class);

        //Membership
        $this->call(GroupSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AccessSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PermissionAccessSeeder::class);

        //Profile
        $this->call(ProfileSeeder::class);

        //Departure (Dummy Data)
//        $this->call(DepartureSeeder::class);
//        $this->call(DepartureMetaSeeder::class);

        //Element (Dummy Data)
//        $this->call(SobtSeeder::class);
//        $this->call(TobtSeeder::class);

    }
}
