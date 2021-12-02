<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['username' => 'super.admin', 'email' => 'super.admin@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'admin', 'email' => 'admin@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'military', 'email' => 'military@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'airport.operator', 'email' => 'airport.operator@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'ground.service', 'email' => 'ground.service@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'airline.operation.center', 'email' => 'airline.operation.center@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'dispatcher', 'email' => 'dispatcher@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'gh.coordinator', 'email' => 'gh.coordinator@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'supervisor', 'email' => 'supervisor@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'clearance.delivery', 'email' => 'clearance.delivery@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'ground.controller', 'email' => 'ground.controller@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'runway.controller', 'email' => 'runway.controller@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'flow.control', 'email' => 'flow.control@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'approach.control', 'email' => 'approach.control@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'area.control', 'email' => 'area.control@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'air.traffic.controller', 'email' => 'air.traffic.controller@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
            ['username' => 'cargo.operation.center', 'email' => 'cargo.operation.center@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],

            ['username' => 'developer', 'email' => 'developer@gmail.com', 'password' => \Hash::make('12345'), 'status' => 'ACTIVE', 'created_by' => 'system'],
        ]);
    }
}
