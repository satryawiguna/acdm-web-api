<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            ['profileable_id' => 1, 'profileable_type' => 'users','full_name' => 'Super Admin', 'nick_name' => 'Super Admin', 'email' => 'super.admin@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 2, 'profileable_type' => 'users','full_name' => 'Admin', 'nick_name' => 'Admin', 'email' => 'admin@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 3, 'profileable_type' => 'users','full_name' => 'Military', 'nick_name' => 'Military', 'email' => 'military@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 4, 'profileable_type' => 'users','full_name' => 'Airport Operator', 'nick_name' => 'Airport Operator', 'email' => 'airport.operator@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 5, 'profileable_type' => 'users','full_name' => 'Ground Service', 'nick_name' => 'Ground Service', 'email' => 'ground.service@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 6, 'profileable_type' => 'users','full_name' => 'Airline Operation', 'nick_name' => 'Airline Operator', 'email' => 'airline.operation.center@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 7, 'profileable_type' => 'users','full_name' => 'Dispatcher', 'nick_name' => 'Dispatcher', 'email' => 'dispatcher@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 8, 'profileable_type' => 'users','full_name' => 'GH Coordinator', 'nick_name' => 'GH Coordinator', 'email' => 'gh.coordinator@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 9, 'profileable_type' => 'users','full_name' => 'Supervisor', 'nick_name' => 'Supervisor', 'email' => 'supervisor@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 10, 'profileable_type' => 'users','full_name' => 'Clearance Delivery', 'nick_name' => 'Clearance Delivery', 'email' => 'clearance.delivery@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 11, 'profileable_type' => 'users','full_name' => 'Ground Controller', 'nick_name' => 'Ground Controller', 'email' => 'ground.controller@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 12, 'profileable_type' => 'users','full_name' => 'Flow Control', 'nick_name' => 'Flow Control', 'email' => 'flow.control@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 13, 'profileable_type' => 'users','full_name' => 'Approach Control', 'nick_name' => 'Approach Control', 'email' => 'approach.control@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 14, 'profileable_type' => 'users','full_name' => 'Area Control', 'nick_name' => 'Area Control', 'email' => 'area.control@gmail.com', 'created_by' => 'system'],
            ['profileable_id' => 15, 'profileable_type' => 'users','full_name' => 'Developer', 'nick_name' => 'Developer', 'email' => 'developer@gmail.com', 'created_by' => 'system'],
        ]);
    }
}
