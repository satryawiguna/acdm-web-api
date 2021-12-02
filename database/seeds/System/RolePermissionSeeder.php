<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->insert([
            //Super admin
            ['role_id' => 1, 'permission_id' => 1, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 2, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 3, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 4, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 5, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 6, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 7, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 8, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 9, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 10, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 11, 'type' => 'READ', 'value' => "ALLOW"],

            //Admin
            ['role_id' => 2, 'permission_id' => 1, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 2, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 3, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 4, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 5, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 6, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 7, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 8, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 9, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 10, 'type' => 'READ', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 11, 'type' => 'READ', 'value' => "ALLOW"],
        ]);
    }
}
