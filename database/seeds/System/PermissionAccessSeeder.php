<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_accesses')->insert([
            ['permission_id' => 1, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 1, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 1, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 1, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 2, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 2, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 2, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 2, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 3, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 3, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 3, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 3, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 4, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 4, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 4, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 4, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 5, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 5, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 5, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 5, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 6, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 6, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 6, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 6, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 7, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 7, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 7, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 7, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 8, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 8, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 8, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 8, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 8, 'access_id' => 14, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 9, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 9, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 9, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 9, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 10, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 10, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 10, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 10, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 11, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 11, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 11, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 11, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 12, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 12, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 12, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 12, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 12, 'access_id' => 14, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 13, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 13, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 13, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 13, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 14, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 14, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 14, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 14, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 15, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 15, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 15, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 15, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],

            ['permission_id' => 16, 'access_id' => 2, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 16, 'access_id' => 3, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 16, 'access_id' => 4, 'type' => 'WRITE', 'value' => 'ALLOW'],
            ['permission_id' => 16, 'access_id' => 5, 'type' => 'WRITE', 'value' => 'ALLOW'],
        ]);
    }
}
