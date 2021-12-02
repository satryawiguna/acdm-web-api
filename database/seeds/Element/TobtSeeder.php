<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TobtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tobts')->insert([
            [
                'departure_id' => 5,
                'tobt' => '2020-07-10 14:24:02',
                'reason' => 'no reason',
                'init' => true,
                'role_id' => 18,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ],
            [
                'departure_id' => 5,
                'tobt' => '2020-07-11 15:25:03',
                'reason' => 'no reason',
                'init' => false,
                'role_id' => 1,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ]
        ]);
    }
}
