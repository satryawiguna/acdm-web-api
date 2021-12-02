<?php

use App\Service\Contracts\Departure\IDepartureService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DepartureSeeder extends Seeder
{
    private IDepartureService $_departureService;

    public function __construct(IDepartureService $departureService)
    {
        $this->_departureService = $departureService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table('departures')->insert([
            [
                'airport_id' => 1,
                'aodb_id' => 101,
                'flight_number' => 'XH3453',
                'flight_number_role_id' => 18,
                'call_sign' => 'MARVY',
                'nature' => 'GA',
                'nature_role_id' => 18,
                'acft' => 'FA7',
                'acft_role_id' => 18,
                'register' => 'MARVY',
                'register_role_id' => 18,
                'stand' => 'DIA-A15',
                'stand_role_id' => 18,
                'gate_name' => null,
                'gate_name_role_id' => 18,
                'gate_open' => null,
                'gate_open_role_id' => 18,
                'runway_actual' => null,
                'runway_actual_role_id' => 18,
                'runway_estimated' => null,
                'runway_estimated_role_id' => 18,
                'transit' => null,
                'transit_role_id' => 18,
                'destination' => 'GVA',
                'destination_role_id' => 18,
                'status' => 'scheduled',
                'code_share' => null,
                'role_id' => 18,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ],
            [
                'airport_id' => 1,
                'aodb_id' => 102,
                'flight_number' => 'PVT001',
                'flight_number_role_id' => 18,
                'call_sign' => 'A7HHK',
                'nature' => 'POS',
                'nature_role_id' => 18,
                'acft' => '342',
                'acft_role_id' => 18,
                'register' => 'A7HHK',
                'register_role_id' => 18,
                'stand' => 'DIA-E21',
                'stand_role_id' => 18,
                'gate_name' => null,
                'gate_name_role_id' => 18,
                'gate_open' => null,
                'gate_open_role_id' => 18,
                'runway_actual' => null,
                'runway_actual_role_id' => 18,
                'runway_estimated' => null,
                'runway_estimated_role_id' => 18,
                'transit' => null,
                'transit_role_id' => 18,
                'destination' => 'AGA',
                'destination_role_id' => 18,
                'status' => 'scheduled',
                'code_share' => null,
                'role_id' => 18,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ],
            [
                'airport_id' => 1,
                'aodb_id' => 103,
                'flight_number' => 'XH3452',
                'flight_number_role_id' => 18,
                'call_sign' => '9HBIG',
                'nature' => 'GA',
                'nature_role_id' => 18,
                'acft' => '343',
                'acft_role_id' => 18,
                'register' => '9HBIG',
                'register_role_id' => 18,
                'stand' => 'DIA-A06',
                'stand_role_id' => 18,
                'gate_name' => null,
                'gate_name_role_id' => 18,
                'gate_open' => null,
                'gate_open_role_id' => 18,
                'runway_actual' => null,
                'runway_actual_role_id' => 18,
                'runway_estimated' => null,
                'runway_estimated_role_id' => 18,
                'transit' => null,
                'transit_role_id' => 18,
                'destination' => 'CDG',
                'destination_role_id' => 18,
                'status' => 'scheduled',
                'code_share' => null,
                'role_id' => 18,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ],
            [
                'airport_id' => 1,
                'aodb_id' => 104,
                'flight_number' => 'ME500',
                'flight_number_role_id' => 18,
                'call_sign' => 'MEA500',
                'nature' => 'GA',
                'nature_role_id' => 18,
                'acft' => 'EP1',
                'acft_role_id' => 18,
                'register' => 'ODCXJ',
                'register_role_id' => 18,
                'stand' => 'DIA-A05',
                'stand_role_id' => 18,
                'gate_name' => null,
                'gate_name_role_id' => 18,
                'gate_open' => null,
                'gate_open_role_id' => 18,
                'runway_actual' => null,
                'runway_actual_role_id' => 18,
                'runway_estimated' => null,
                'runway_estimated_role_id' => 18,
                'transit' => null,
                'transit_role_id' => 18,
                'destination' => 'BEY',
                'destination_role_id' => 18,
                'status' => 'scheduled',
                'code_share' => null,
                'role_id' => 18,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ],
            [
                'airport_id' => 1,
                'aodb_id' => 105,
                'flight_number' => 'QR131D',
                'flight_number_role_id' => 18,
                'call_sign' => 'QTR131D',
                'nature' => 'PAX',
                'nature_role_id' => 18,
                'acft' => '346',
                'acft_role_id' => 18,
                'register' => 'A7AGD',
                'register_role_id' => 18,
                'stand' => 'H4',
                'stand_role_id' => 18,
                'gate_name' => null,
                'gate_name_role_id' => 18,
                'gate_open' => null,
                'gate_open_role_id' => 18,
                'runway_actual' => null,
                'runway_actual_role_id' => 18,
                'runway_estimated' => null,
                'runway_estimated_role_id' => 18,
                'transit' => null,
                'transit_role_id' => 18,
                'destination' => 'FCO',
                'destination_role_id' => 18,
                'status' => 'scheduled',
                'code_share' => null,
                'role_id' => 18,
                'created_by' => 'system',
                'created_at' => new DateTime('now')
            ],
        ]);
    }
}
