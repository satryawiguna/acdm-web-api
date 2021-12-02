<?php
namespace App\Help\Infrastructure\Persistence\UnitOfWork;


use Spatie\Enum\Enum;

class RelationMethodType extends Enum
{
    public static function SAVE_MANY(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'saveMany';
            }
            public function getIndex(): int
            {
                return 0;
            }
        };
    }

    public static function CREATE_MANY(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'createMany';
            }
            public function getIndex(): int
            {
                return 1;
            }
        };
    }

    public static function ASSOCIATE(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'associate';
            }
            public function getIndex(): int
            {
                return 2;
            }
        };
    }

    public static function DISSOCIATE(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'dissociate';
            }
            public function getIndex(): int
            {
                return 3;
            }
        };
    }

    public static function ATTACH(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'attach';
            }
            public function getIndex(): int
            {
                return 4;
            }
        };
    }

    public static function DETACH(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'detach';
            }
            public function getIndex(): int
            {
                return 5;
            }
        };
    }

    public static function SYNC(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'sync';
            }
            public function getIndex(): int
            {
                return 6;
            }
        };
    }

    public static function PUSH(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'push';
            }
            public function getIndex(): int
            {
                return 7;
            }
        };
    }

    public static function SAVE(): RelationMethodType
    {
        return new class() extends RelationMethodType {
            public function getValue(): string
            {
                return 'save';
            }
            public function getIndex(): int
            {
                return 8;
            }
        };
    }
}
