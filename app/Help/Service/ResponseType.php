<?php
namespace App\Help\Service;


use Spatie\Enum\Enum;

class ResponseType extends Enum
{
    public static function SUCCESS(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 200;
            }
            public function getIndex(): int
            {
                return 0;
            }
        };
    }

    public static function BAD_REQUEST(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 400;
            }
            public function getIndex(): int
            {
                return 1;
            }
        };
    }

    public static function UNAUTHORIZED(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 401;
            }
            public function getIndex(): int
            {
                return 2;
            }
        };
    }

    public static function FORBIDDEN(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 403;
            }
            public function getIndex(): int
            {
                return 3;
            }
        };
    }

    public static function NOT_FOUND(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 404;
            }
            public function getIndex(): int
            {
                return 4;
            }
        };
    }

    public static function UNSUPPORT_MEDIA(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 415;
            }
            public function getIndex(): int
            {
                return 5;
            }
        };
    }

    public static function INTERNAL_SERVER_ERROR(): ResponseType
    {
        return new class() extends ResponseType {
            public function getValue(): string
            {
                return 500;
            }
            public function getIndex(): int
            {
                return 6;
            }
        };
    }
}
