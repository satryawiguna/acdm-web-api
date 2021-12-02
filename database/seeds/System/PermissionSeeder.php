<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['name' => 'Manage System', 'slug' => 'manage-system', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/system', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Group', 'slug' => 'manage-group', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/system/group', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Role', 'slug' => 'manage-role', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/system/role', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Permission', 'slug' => 'manage-permission', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/system/permission', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Access', 'slug' => 'manage-access', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/system/access', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Setting', 'slug' => 'manage-setting', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/system/setting', 'created_by' => 'system', 'created_at' => new DateTime('now')],

            ['name' => 'Manage Master Data', 'slug' => 'manage-master-data', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/master-data', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Airport', 'slug' => 'manage-airport', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/master-data/airport', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Airline', 'slug' => 'manage-airline', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/master-data/airline', 'created_by' => 'system', 'created_at' => new DateTime('now')],

            ['name' => 'Manage Membership', 'slug' => 'manage-membership', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/membership', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage User', 'slug' => 'manage-user', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/membership/user', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                    ['name' => 'Manage Profile', 'slug' => 'manage-profile', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/membership/user/{id}/profile', 'created_by' => 'system', 'created_at' => new DateTime('now')],

            ['name' => 'Manage Departure', 'slug' => 'manage-departure', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Schedule of Block Time', 'slug' => 'manage-schedule-of-block-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/schedule-of-block-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Target of Block Time', 'slug' => 'manage-target-of-block-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/target-of-block-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual Commence Ground Handling Time', 'slug' => 'manage-actual-commence-ground-handling-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-commence-ground-handling-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual end Ground Handling Time', 'slug' => 'manage-actual-end-ground-handling-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-end-ground-handling-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual Ready Time', 'slug' => 'manage-actual-ready-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-ready-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual Start Boarding Time', 'slug' => 'manage-actual-start-boarding-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-start-boarding-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual Start-up Request Time', 'slug' => 'manage-actual-start-up-request-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-start-up-request-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Target Start-up Approval Time', 'slug' => 'manage-target-start-up-approval-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/target-start-up-approval-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual Commence De-icing Time', 'slug' => 'manage-actual-commence-de-icing-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-commence-de-icing-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
                ['name' => 'Manage Actual end of De-icing Time', 'slug' => 'manage-actual-end-of-de-icing-time', 'server' => 'https://acdm-platform-v2.local', 'path' => '/api/v1/departure/actual-end-of-de-icing-time', 'created_by' => 'system', 'created_at' => new DateTime('now')],
        ]);
    }
}
