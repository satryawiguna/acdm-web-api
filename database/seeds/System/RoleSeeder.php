<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['group_id' => 1, 'name' => 'Super Admin', 'slug' => 'super-admin', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Admin', 'slug' => 'admin', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Military', 'slug' => 'military', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Airport Operator', 'slug' => 'airport-operator', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Ground Services', 'slug' => 'ground-service', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Airline Operation Center', 'slug' => 'airline-operation-center', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Dispatcher', 'slug' => 'dispatcher', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'GH Coordinator', 'slug' => 'gh-coordinator', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Supervisor', 'slug' => 'supervisor', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Clearance Delivery', 'slug' => 'clearance-delivery', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Ground Controller', 'slug' => 'ground-controller', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Runway Controller', 'slug' => 'runway-controller', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Flow Control', 'slug' => 'flow-controller', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Approach Control', 'slug' => 'approach-control', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Area Control', 'slug' => 'area-control', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Air Traffic Control', 'slug' => 'air-traffic-control', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
            ['group_id' => 1, 'name' => 'Cargo Operation Center', 'slug' => 'cargo-operation-center', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],

            ['group_id' => 2, 'name' => 'Developer', 'slug' => 'developer', 'description' => null, 'created_by' => 'system', 'created_at' => new DateTime('now')],
        ]);
    }
}
