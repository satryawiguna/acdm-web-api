<?php
namespace App\Help\Core\Service\Response;


use Spatie\Enum\Enum;

class MessageType extends Enum
{
    public static function ERROR(): MessageType
    {
        return new class() extends MessageType {
            public function getValue(): string
            {
                return 'ERROR';
            }
            public function getIndex(): int
            {
                return 0;
            }
        };
    }

    public static function INFO(): MessageType
    {
        return new class() extends MessageType {
            public function getValue(): string
            {
                return 'INFO';
            }
            public function getIndex(): int
            {
                return 1;
            }
        };
    }

    public static function WARNING(): MessageType
    {
        return new class() extends MessageType {
            public function getValue(): string
            {
                return 'WARNING';
            }
            public function getIndex(): int
            {
                return 2;
            }
        };
    }
}
