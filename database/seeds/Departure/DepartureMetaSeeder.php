<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartureMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departure_metas')->insert([
            [
                'departure_id' => 1,
                'flight' => json_encode([
                        "acknowledge"=>false,
                        "priority"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "type"=>null
                        ],
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'sobt' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'eobt' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'tobt' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'aegt' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'ardt' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'tsat' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'aobt' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'ttot' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'atot' => json_encode([
                        "tickmark"=>[
                            "icon"=>null,
                            "blink"=>false,
                            "color"=>null
                        ]
                    ]),
                'created_by' => 'system'
            ],
            [
                'departure_id' => 2,
                'flight' => json_encode([
                    "acknowledge"=>false,
                    "priority"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "type"=>null
                    ],
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'sobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'eobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aegt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ardt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tsat' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ttot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'atot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'created_by' => 'system'
            ],
            [
                'departure_id' => 3,
                'flight' => json_encode([
                    "acknowledge"=>false,
                    "priority"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "type"=>null
                    ],
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'sobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'eobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aegt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ardt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tsat' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ttot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'atot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'created_by' => 'system'
            ],
            [
                'departure_id' => 4,
                'flight' => json_encode([
                    "acknowledge"=>false,
                    "priority"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "type"=>null
                    ],
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'sobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'eobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aegt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ardt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tsat' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ttot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'atot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'created_by' => 'system'
            ],
            [
                'departure_id' => 5,
                'flight' => json_encode([
                    "acknowledge"=>false,
                    "priority"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "type"=>null
                    ],
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'sobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'eobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aegt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ardt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'tsat' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'aobt' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'ttot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'atot' => json_encode([
                    "tickmark"=>[
                        "icon"=>null,
                        "blink"=>false,
                        "color"=>null
                    ]
                ]),
                'created_by' => 'system'
            ]
        ]);
    }
}
