<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accesses')->insert([
            ['name' => 'ANY', 'slug' => 'any', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'GET', 'slug' => 'get', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'POST', 'slug' => 'post', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'PUT', 'slug' => 'put', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'DELETE', 'slug' => 'delete', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'APPROVE', 'slug' => 'approve', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'REJECT', 'slug' => 'reject', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'CREATE', 'slug' => 'create', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'AUTHORIZE', 'slug' => 'authorize', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'UNAUTHORIZE', 'slug' => 'unauthorize', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'BACKUP', 'slug' => 'backup', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'RESTORE', 'slug' => 'restore', 'created_by' => 'system', 'created_at' => new DateTime('now')],

            ['name' => 'PRINT', 'slug' => 'print', 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'ACKNOWLEDGE', 'slug' => 'acknowledge', 'created_by' => 'system', 'created_at' => new DateTime('now')],
        ]);
    }
}
