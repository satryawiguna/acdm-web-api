<?php
namespace App\Infrastructure\Persistence\ModelFacades\Departure;


use App\Infrastructure\Persistence\ModelFacades\BaseModelFacade;
use App\Infrastructure\Persistence\ModelFacades\Contracts\Departure\IDepartureModelFacade;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DepartureModelFacade extends BaseModelFacade implements IDepartureModelFacade
{
    public function findWhereByKeyword(string $keyword)
    {
        $parameter = [
            'flight_number' => '%' . $keyword . '%',
            'call_sign' => '%' . $keyword . '%',
            'nature' => '%' . $keyword . '%',
            'acft' => '%' . $keyword . '%',
            'register' => '%' . $keyword . '%',
            'stand' => '%' . $keyword . '%',
            'gate_name' => '%' . $keyword . '%',
            'runway_actual' => '%' . $keyword . '%',
            'runway_estimated' => '%' . $keyword . '%',
            'transit' => '%' . $keyword . '%',
            'destination' => '%' . $keyword . '%',
        ];

        $this->model = $this->model->whereRaw("(flight_number LIKE ? OR
            call_sign LIKE ? OR
            nature LIKE ? OR
            acft LIKE ? OR
            register LIKE ? OR
            stand LIKE ? OR
            gate_name LIKE ? OR
            runway_actual LIKE ? OR
            runway_estimated LIKE ? OR
            transit LIKE ? OR
            destination LIKE ?)", $parameter)
            ->orWhereHas('airport', function($q) use($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%');
            });

        return $this;
    }

    public function fromDepartures()
    {
        switch (config('global.timezone')) {
            case 'Asia/Qatar':
                $query = "(SELECT `??`.`id`, `??`.`aodb_id`, `??`.`airport_id`,
                          (SELECT `?airports`.`name` FROM `?airports` WHERE `??`.`airport_id` = `?airports`.`id`) as airport_name,

                          `??`.`flight_number`,
                          (SELECT `?flight_informations`.`reason` FROM `?flight_informations` WHERE `?flight_informations`.`departure_id` = `??`.`id` ORDER BY `??`.`id` DESC LIMIT 0,1) as flight_reason,

                          IF(`??`.`flight_numberable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`flight_numberable_id`),
                             IF(`??`.`flight_numberable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`flight_numberable_id`),
                                NULL
                             )
                          ) as flight_number_role_name,

                          `??`.`call_sign`,

                          `??`.`nature`,
                          IF(`??`.`natureable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`natureable_id`),
                             IF(`??`.`natureable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`natureable_id`),
                                NULL
                             )
                          ) as nature_role_name,

                          `??`.`acft`,
                          IF(`??`.`acftable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`acftable_id`),
                             IF(`??`.`acftable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`acftable_id`),
                                NULL
                             )
                          ) as acft_role_name,

                          `??`.`register`,
                          IF(`??`.`registerable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`registerable_id`),
                             IF(`??`.`registerable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`registerable_id`),
                                NULL
                             )
                          ) as register_role_name,

                          `??`.`stand`,
                          IF(`??`.`standable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`standable_id`),
                             IF(`??`.`standable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`standable_id`),
                                NULL
                             )
                          ) as stand_role_name,

                          `??`.`gate_name`,
                          IF(`??`.`gate_nameable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`gate_nameable_id`),
                             IF(`??`.`gate_nameable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`gate_nameable_id`),
                                NULL
                             )
                          ) as gate_name_role_name,

                          CONVERT_TZ(`??`.`gate_open`, 'UTC', 'Asia/Qatar') as gate_open,
                          IF(`??`.`gate_openable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`gate_openable_id`),
                             IF(`??`.`gate_openable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`gate_openable_id`),
                                NULL
                             )
                          ) as gate_open_role_name,

                          `??`.`runway_actual`,
                          IF(`??`.`runway_actualable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`runway_actualable_id`),
                             IF(`??`.`runway_actualable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`runway_actualable_id`),
                                NULL
                             )
                          ) as runway_actual_role_name,

                          `??`.`runway_estimated`,
                          IF(`??`.`runway_estimatedable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`runway_estimatedable_id`),
                             IF(`??`.`runway_estimatedable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`runway_estimatedable_id`),
                                NULL
                             )
                          ) as runway_estimated_role_name,

                          `??`.`transit`,
                          IF(`??`.`transitable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`transitable_id`),
                             IF(`??`.`transitable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`transitable_id`),
                                NULL
                             )
                          ) as transit_role_name,

                          `??`.`destination` AS `destination_by_iata`,
                          IF(`??`.`destination` IS NOT NULL,
                             IF(`??`.`destination` != '',
                                (SELECT `?airports`.`icao` FROM `?airports` WHERE `?airports`.`iata` = `??`.`destination`),
                                NULl
                             ),
                             NULL
                          ) AS `destination_by_icao`,
                          IF(`??`.`destinationable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`destinationable_id`),
                             IF(`??`.`destinationable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`destinationable_id`),
                                NULL
                             )
                          ) as destination_role_name,

                          `??`.`status`, `??`.`code_share`,
                          `??`.`data_origin`,

                          IF(`??`.`data_originable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`data_originable_id`),
                             IF(`??`.`data_originable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`data_originable_id`),
                                NULL
                             )
                          ) as data_origin_role_name,

                          `??`.`created_by`, `??`.`updated_by`, `??`.`created_at`, `??`.`updated_at`, `??`.`deleted_at`,

                          CONVERT_TZ((SELECT `?sobts`.`sobt` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as sobt,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as sobt_role_name,

                          CONVERT_TZ((SELECT `?eobts`.`eobt` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as eobt,
                          IF((SELECT `?eobts`.`eobtable_type` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?eobts`.`eobtable_id` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?eobts`.`eobtable_type` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?eobts`.`eobtable_id` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as eobt_role_name,

                          CONVERT_TZ((SELECT `?tobts`.`tobt` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as tobt,
                          IF((SELECT `?tobts`.`tobtable_type` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?tobts`.`tobtable_id` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?tobts`.`tobtable_type` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?tobts`.`tobtable_id` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as tobt_role_name,

                          CONVERT_TZ((SELECT `?aegts`.`aegt` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as aegt,
                          IF((SELECT `?aegts`.`aegtable_type` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?aegts`.`aegtable_id` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?aegts`.`aegtable_type` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?aegts`.`aegtable_id` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as aegt_role_name,

                          CONVERT_TZ((SELECT `?ardts`.`ardt` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as ardt,
                          IF((SELECT `?ardts`.`ardtable_type` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?ardts`.`ardtable_id` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?ardts`.`ardtable_type` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?ardts`.`ardtable_id` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as ardt_role_name,

                          CONVERT_TZ((SELECT `?tsats`.`tsat` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as tsat,
                          IF((SELECT `?tsats`.`tsatable_type` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?tsats`.`tsatable_id` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?tsats`.`tsatable_type` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?tsats`.`tsatable_id` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as tsat_role_name,

                          CONVERT_TZ((SELECT `?aobts`.`aobt` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as aobt,
                          IF((SELECT `?aobts`.`aobtable_type` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?aobts`.`aobtable_id` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?aobts`.`aobtable_type` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?aobts`.`aobtable_id` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as aobt_role_name,

                          CONVERT_TZ((SELECT `?acgts`.`acgt` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as acgt,
                          IF((SELECT `?acgts`.`acgtable_type` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?acgts`.`acgtable_id` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?acgts`.`acgtable_type` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?acgts`.`acgtable_id` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as acgt_role_name,

                          CONVERT_TZ((SELECT `?ttots`.`ttot` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as ttot,
                          IF((SELECT `?ttots`.`ttotable_type` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?ttots`.`ttotable_id` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?ttots`.`ttotable_type` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?ttots`.`ttotable_id` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as ttot_role_name,

                          CONVERT_TZ((SELECT `?atots`.`atot` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as atot,
                          IF((SELECT `?atots`.`atotable_type` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?atots`.`atotable_id` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?atots`.`atotable_type` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?atots`.`atotable_id` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as atot_role_name
                          FROM `??`) AS `??`";
                break;

            case 'UTC':
            default:
                $query = "(SELECT `??`.`id`, `??`.`aodb_id`, `??`.`airport_id`,
                          (SELECT `?airports`.`name` FROM `?airports` WHERE `??`.`airport_id` = `?airports`.`id`) as airport_name,

                          `??`.`flight_number`,
                          (SELECT `?flight_informations`.`reason` FROM `?flight_informations` WHERE `?flight_informations`.`departure_id` = `??`.`id` ORDER BY `??`.`id` DESC LIMIT 0,1) as flight_reason,
                          IF(`??`.`flight_numberable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`flight_numberable_id`),
                             IF(`??`.`flight_numberable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`flight_numberable_id`),
                                NULL
                             )
                          ) as flight_number_role_name,

                          `??`.`call_sign`,

                          `??`.`nature`,
                          IF(`??`.`natureable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`natureable_id`),
                             IF(`??`.`natureable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`natureable_id`),
                                NULL
                             )
                          ) as nature_role_name,

                          `??`.`acft`,
                          IF(`??`.`acftable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`acftable_id`),
                             IF(`??`.`acftable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`acftable_id`),
                                NULL
                             )
                          ) as acft_role_name,

                          `??`.`register`,
                          IF(`??`.`registerable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`registerable_id`),
                             IF(`??`.`registerable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`registerable_id`),
                                NULL
                             )
                          ) as register_role_name,

                          `??`.`stand`,
                          IF(`??`.`standable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`standable_id`),
                             IF(`??`.`standable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`standable_id`),
                                NULL
                             )
                          ) as stand_role_name,

                          `??`.`gate_name`,
                          IF(`??`.`gate_nameable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`gate_nameable_id`),
                             IF(`??`.`gate_nameable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`gate_nameable_id`),
                                NULL
                             )
                          ) as gate_name_role_name,

                          `??`.`gate_open`,
                          IF(`??`.`gate_openable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`gate_openable_id`),
                             IF(`??`.`gate_openable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`gate_openable_id`),
                                NULL
                             )
                          ) as gate_open_role_name,

                          `??`.`runway_actual`,
                          IF(`??`.`runway_actualable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`runway_actualable_id`),
                             IF(`??`.`runway_actualable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`runway_actualable_id`),
                                NULL
                             )
                          ) as runway_actual_role_name,

                          `??`.`runway_estimated`,
                          IF(`??`.`runway_estimatedable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`runway_estimatedable_id`),
                             IF(`??`.`runway_estimatedable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`runway_estimatedable_id`),
                                NULL
                             )
                          ) as runway_estimated_role_name,

                          `??`.`transit`,
                          IF(`??`.`transitable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`transitable_id`),
                             IF(`??`.`transitable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`transitable_id`),
                                NULL
                             )
                          ) as transit_role_name,

                         `??`.`destination` AS `destination_by_iata`,
                          IF(`??`.`destination` IS NOT NULL,
                             IF(`??`.`destination` != '',
                                (SELECT `?airports`.`icao` FROM `?airports` WHERE `?airports`.`iata` = `??`.`destination`),
                                NULl
                             ),
                             NULL
                          ) AS `destination_by_icao`,
                          IF(`??`.`destinationable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`destinationable_id`),
                             IF(`??`.`destinationable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`destinationable_id`),
                                NULL
                             )
                          ) as destination_role_name,

                          `??`.`status`, `??`.`code_share`,
                          `??`.`data_origin`,

                          IF(`??`.`data_originable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `??`.`data_originable_id`),
                             IF(`??`.`data_originable_type` = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `??`.`data_originable_id`),
                                NULL
                             )
                          ) as data_origin_role_name,

                          `??`.`created_by`, `??`.`updated_by`, `??`.`created_at`, `??`.`updated_at`, `??`.`deleted_at`,

                          (SELECT `?sobts`.`sobt` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1) as sobt,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as sobt_role_name,

                          (SELECT `?eobts`.`eobt` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1) as eobt,
                          IF((SELECT `?eobts`.`eobtable_type` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?eobts`.`eobtable_id` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?eobts`.`eobtable_type` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?eobts`.`eobtable_id` FROM `?eobts` WHERE `?eobts`.`departure_id` = `??`.`id` ORDER BY `?eobts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as eobt_role_name,

                          (SELECT `?tobts`.`tobt` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1) as tobt,
                          IF((SELECT `?tobts`.`tobtable_type` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?tobts`.`tobtable_id` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?tobts`.`tobtable_type` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?tobts`.`tobtable_id` FROM `?tobts` WHERE `?tobts`.`departure_id` = `??`.`id` ORDER BY `?tobts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as tobt_role_name,

                          (SELECT `?aegts`.`aegt` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1) as aegt,
                          IF((SELECT `?aegts`.`aegtable_type` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?aegts`.`aegtable_id` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1)),
                             IF((SELECT `?aegts`.`aegtable_type` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1) = 'roles',
                                (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?aegts`.`aegtable_id` FROM `?aegts` WHERE `?aegts`.`departure_id` = `??`.`id` ORDER BY `?aegts`.`id` DESC LIMIT 0,1)),
                                NULL)
                          ) as aegt_role_name,

                          (SELECT `?ardts`.`ardt` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1) as ardt,
                          IF((SELECT `?ardts`.`ardtable_type` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?ardts`.`ardtable_id` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?ardts`.`ardtable_type` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?ardts`.`ardtable_id` FROM `?ardts` WHERE `?ardts`.`departure_id` = `??`.`id` ORDER BY `?ardts`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as ardt_role_name,

                          (SELECT `?tsats`.`tsat` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1) as tsat,
                          IF((SELECT `?tsats`.`tsatable_type` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?tsats`.`tsatable_id` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?tsats`.`tsatable_type` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?tsats`.`tsatable_id` FROM `?tsats` WHERE `?tsats`.`departure_id` = `??`.`id` ORDER BY `?tsats`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as tsat_role_name,

                          (SELECT `?aobts`.`aobt` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1) as aobt,
                          IF((SELECT `?aobts`.`aobtable_type` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?aobts`.`aobtable_id` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?aobts`.`aobtable_type` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?aobts`.`aobtable_id` FROM `?aobts` WHERE `?aobts`.`departure_id` = `??`.`id` ORDER BY `?aobts`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as aobt_role_name,

                          (SELECT `?acgts`.`acgt` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1) as acgt,
                          IF((SELECT `?acgts`.`acgtable_type` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?acgts`.`acgtable_id` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?acgts`.`acgtable_type` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?acgts`.`acgtable_id` FROM `?acgts` WHERE `?acgts`.`departure_id` = `??`.`id` ORDER BY `?acgts`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as acgt_role_name,

                          (SELECT `?ttots`.`ttot` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1) as ttot,
                          IF((SELECT `?ttots`.`ttotable_type` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?ttots`.`ttotable_id` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?ttots`.`ttotable_type` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?ttots`.`ttotable_id` FROM `?ttots` WHERE `?ttots`.`departure_id` = `??`.`id` ORDER BY `?ttots`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as ttot_role_name,

                          (SELECT `?atots`.`atot` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1) as atot,
                          IF((SELECT `?atots`.`atotable_type` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1) = 'vendors',
                              (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?atots`.`atotable_id` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1)),
                              IF((SELECT `?atots`.`atotable_type` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1) = 'roles',
                              (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?atots`.`atotable_id` FROM `?atots` WHERE `?atots`.`departure_id` = `??`.`id` ORDER BY `?atots`.`id` DESC LIMIT 0,1)),
                              NULL)
                          ) as atot_role_name
                          FROM `??`) AS `??`";
                break;
        }

        $this->model = $this->model->from(DB::raw(strtr($query, ['?' => env('DB_TABLE_PREFIX'), '??' => env('DB_TABLE_PREFIX').$this->modelInstance()->getTable()])));

        return $this;
    }

    public function fromDeparturesTobtUpdated()
    {
        switch (config('global.timezone')) {
            case 'Asia/Qatar':
                $selectQuery = "`??`.*,
                            CONVERT_TZ(`?tobts`.`tobt`, 'UTC', 'Asia/Qatar') as tobt_updated,
                            CONVERT_TZ(`?tobts`.`created_at`, 'UTC', 'Asia/Qatar') as tobt_time_updated,
                            IF(`?tobts`.`tobtable_type` = 'vendors',
                               (SELECT `?vendors`.`id` FROM `?vendors` WHERE `?vendors`.`id` = `?tobts`.`tobtable_id`),
                               NULL
                            ) as tobt_vendor_id,
                            IF(`?tobts`.`tobtable_type` = 'roles',
                               (SELECT `?roles`.`id` FROM `?roles` WHERE `?roles`.`id` = `?tobts`.`tobtable_id`),
                               NULL
                            ) as tobt_role_id,
                            IF(`?tobts`.`tobtable_type` = 'vendors',
                               (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `?tobts`.`tobtable_id`),
                               NULL
                            ) as tobt_vendor_name,
                            IF(`?tobts`.`tobtable_type` = 'roles',
                               (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `?tobts`.`tobtable_id`),
                               NULL
                            ) as tobt_role_name";

                $fromQuery = "(SELECT `??`.`id`, `??`.`aodb_id`, `??`.`airport_id`,
                          (SELECT `?airports`.`name` FROM `?airports` WHERE `??`.`airport_id` = `?airports`.`id`) as airport_name,
                          `??`.`flight_number`,
                          (SELECT `?flight_informations`.`reason` FROM `?flight_informations` WHERE `?flight_informations`.`departure_id` = `??`.`id` ORDER BY `??`.`id` DESC LIMIT 0,1) as flight_reason,
                          `??`.`call_sign`, `??`.`nature`, `??`.`acft`, `??`.`register`, `??`.`stand`, `??`.`gate_name`,
                          CONVERT_TZ(`??`.`gate_open`, 'Asia/Qatar', 'UTC') as gate_open, `??`.`runway_actual`, `??`.`runway_estimated`, `??`.`transit`, `??`.`destination`, `??`.`status`, `??`.`code_share`,
                          `??`.`created_by`, `??`.`updated_by`, `??`.`created_at`, `??`.`updated_at`, `??`.`deleted_at`,
                          CONVERT_TZ((SELECT `?sobts`.`sobt` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1), 'UTC', 'Asia/Qatar') as sobt,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`id` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_vendor_id,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'roles',
                             (SELECT `?roles`.`id` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_role_id,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_vendor_name,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'roles',
                             (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_role_name
                          FROM `??`) AS `??`";
                break;

            case 'UTC':
            default:
                $selectQuery = "`??`.*,
                          `?tobts`.`tobt` as tobt_updated,
                          `?tobts`.`created_at` as tobt_time_updated,
                          IF(`?tobts`.`tobtable_type` = 'vendors',
                             (SELECT `?vendors`.`id` FROM `?vendors` WHERE `?vendors`.`id` = `?tobts`.`tobtable_id`),
                             NULL
                          ) as tobt_vendor_id,
                          IF(`?tobts`.`tobtable_type` = 'roles',
                             (SELECT `?roles`.`id` FROM `?roles` WHERE `?roles`.`id` = `?tobts`.`tobtable_id`),
                             NULL
                          ) as tobt_role_id,
                          IF(`?tobts`.`tobtable_type` = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = `?tobts`.`tobtable_id`),
                             NULL
                          ) as tobt_vendor_name,
                          IF(`?tobts`.`tobtable_type` = 'roles',
                             (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = `?tobts`.`tobtable_id`),
                             NULL
                          ) as tobt_role_name";

                $fromQuery = "(SELECT `??`.`id`, `??`.`aodb_id`, `??`.`airport_id`,
                          (SELECT `?airports`.`name` FROM `?airports` WHERE `??`.`airport_id` = `?airports`.`id`) as airport_name,
                          `??`.`flight_number`,
                          (SELECT `?flight_informations`.`reason` FROM `?flight_informations` WHERE `?flight_informations`.`departure_id` = `??`.`id` ORDER BY `??`.`id` DESC LIMIT 0,1) as flight_reason,
                          `??`.`call_sign`, `??`.`nature`, `??`.`acft`, `??`.`register`, `??`.`stand`, `??`.`gate_name`,
                          `??`.`gate_open`, `??`.`runway_actual`, `??`.`runway_estimated`, `??`.`transit`, `??`.`destination`, `??`.`status`, `??`.`code_share`,
                          `??`.`created_by`, `??`.`updated_by`, `??`.`created_at`, `??`.`updated_at`, `??`.`deleted_at`,
                          (SELECT `?sobts`.`sobt` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) as sobt,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`id` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_vendor_id,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'roles',
                             (SELECT `?roles`.`id` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_role_id,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'vendors',
                             (SELECT `?vendors`.`name` FROM `?vendors` WHERE `?vendors`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_vendor_name,
                          IF((SELECT `?sobts`.`sobtable_type` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1) = 'roles',
                             (SELECT `?roles`.`name` FROM `?roles` WHERE `?roles`.`id` = (SELECT `?sobts`.`sobtable_id` FROM `?sobts` WHERE `?sobts`.`departure_id` = `??`.`id` ORDER BY `?sobts`.`sobt` DESC LIMIT 0,1)),
                             NULL
                          ) as sobt_role_name
                          FROM `??`) AS `??`";
                break;
        }

        $this->model = $this->model->select(DB::raw(strtr($selectQuery, ['?' => env('DB_TABLE_PREFIX'), '??' => env('DB_TABLE_PREFIX').$this->modelInstance()->getTable()])))
            ->from(DB::raw(strtr($fromQuery, ['?' => env('DB_TABLE_PREFIX'), '??' => env('DB_TABLE_PREFIX').$this->modelInstance()->getTable()])))
            ->join('tobts', function($join) {
                $join->on($this->modelInstance()->getTable().'.id', '=', 'tobts.departure_id');
                $join->whereNull('tobts.deleted_at');
            });

        return $this;
    }

    public function findWhereByStatusIsNotTerminated()
    {
        $this->model = $this->model->whereRaw("('status' <> 'terminated')");

        return $this;
    }

    public function findWhereBetweenByAll(DateTime $start, DateTime $end)
    {
        $this->model = $this->model->whereBetween('gate_open', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('sobt', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('eobt', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('tobt', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('ardt', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('aegt', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('tsat', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('aobt', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('ttot', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ])->orWhereBetween('atot', [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ]);

        return $this;
    }

    public function findWhereBetweenByField(string $field, DateTime $start, DateTime $end)
    {
        $this->model = $this->model->whereBetween($field, [
            $start->format(Config::get('datetime.format.database_datetime')),
            $end->format(Config::get('datetime.format.database_datetime'))
        ]);

        return $this;
    }
}
