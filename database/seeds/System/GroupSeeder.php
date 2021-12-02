<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            ['name' => 'System', 'slug' => 'system', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['name' => 'Developer', 'slug' => 'developer', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')]
        ]);
    }
}
