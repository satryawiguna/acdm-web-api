<?php

use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendors')->insert([
            ['role_id' => null, 'name' => 'A-CDM (A)', 'slug' => 'a-cdm-a', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['role_id' => null, 'name' => 'TRC', 'slug' => 'trc', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['role_id' => null, 'name' => 'QAS TRC', 'slug' => 'qas-trc', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')]
        ]);
    }
}
