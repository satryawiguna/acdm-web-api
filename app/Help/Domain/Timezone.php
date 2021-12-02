<?php
namespace App\Help\Domain;


use Illuminate\Support\Carbon;

class Timezone
{
    public static function convertGetDatetime(string $datetime)
    {
        switch (config('global.timezone')) {
            case 'Asia/Qatar':
                $timeUTC = Carbon::createFromFormat('Y-m-d H:i:s', $datetime, new \DateTimeZone(env('APP_LOCAL_TIMEZONE')));
                $timeAsiaQatar = $timeUTC->setTimezone(new \DateTimeZone('Asia/Qatar'));

                return $timeAsiaQatar->format('Y-m-d H:i:s');
                break;

            case 'UTC':
            default:
                $timeUTC = $datetime;

                return $timeUTC;
                break;
        }
    }

    public static function convertSetDatetime(string $datetime)
    {
        switch (config('global.timezone')) {
            case 'Asia/Qatar':
                $timeAsiaQatar = Carbon::createFromFormat('Y-m-d H:i:s', $datetime, new \DateTimeZone('Asia/Qatar'));
                $timeUTC = $timeAsiaQatar->setTimezone(new \DateTimeZone(env('APP_LOCAL_TIMEZONE')));

                return $timeUTC->format('Y-m-d H:i:s');
                break;

            case 'UTC':
            default:
                $timeUTC = $datetime;

                return $timeUTC;
                break;
        }
    }
}
