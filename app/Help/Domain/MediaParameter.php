<?php


namespace App\Help\Domain;


use Spatie\Enum\Enum;

class MediaParameter extends Enum
{
    public static function AVATAR(): MediaParameter
    {
        return new class() extends MediaParameter {
            public function getValue(): string
            {
                return json_encode([
                    "path" => storage_path("/app/public/avatar"),
                    "url" => env("APP_URL") . "/storage/avatar",
                    "rules" => "image|mimes:jpeg,png,jpg,gif,svg|max:1024",
                    "width" => 500,
                    "height" => 500
                ]);
            }
            public function getIndex(): int
            {
                return 0;
            }
        };
    }

    public static function LOGO(): MediaParameter
    {
        return new class() extends MediaParameter {
            public function getValue(): string
            {
                return json_encode([
                    "path" => storage_path("/app/public/logo"),
                    "url" => env("APP_URL") . "/storage/logo",
                    "rules" => "image|mimes:jpeg,png,jpg,gif,svg|max:1024",
                    "width" => 500,
                    "height" => 500
                ]);
            }
            public function getIndex(): int
            {
                return 1;
            }
        };
    }

    public static function ALL(): MediaParameter
    {
        return new class() extends MediaParameter {
            public function getValue(): string
            {
                return json_encode([
                    "path" => public_path('/medias'),
                    "url" => env("APP_URL") . "/medias",
                    "rules" => "mimes:jpeg,png,jpg,gif,svg,doc,pdf,xls,ppt,txt|max:5120",
                    "width" => 500,
                    "height" => 500
                ]);
            }
            public function getIndex(): int
            {
                return 2;
            }
        };
    }
}
