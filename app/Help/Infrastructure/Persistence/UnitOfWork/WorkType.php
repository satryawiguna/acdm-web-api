<?php
namespace App\Help\Infrastructures\Persistence\UnitOfWorks;


use Spatie\Enum\Enum;

class WorkType extends Enum
{
    public static function INSERT(): WorkType
    {
        return new class() extends WorkType {
            public function getValue(): string
            {
                return 'INSERT';
            }
            public function getIndex(): int
            {
                return 0;
            }
        };
    }

    public static function UPDATE(): WorkType
    {
        return new class() extends WorkType {
            public function getValue(): string
            {
                return 'UPDATE';
            }
            public function getIndex(): int
            {
                return 1;
            }
        };
    }

    public static function DELETE(): WorkType
    {
        return new class() extends WorkType {
            public function getValue(): string
            {
                return 'DELETE';
            }
            public function getIndex(): int
            {
                return 2;
            }
        };
    }
}
