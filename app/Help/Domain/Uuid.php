<?php
namespace App\Help\Domain;


use Ramsey\Uuid\Exception\BuilderNotFoundException;
use Ramsey\Uuid\Uuid as Generator;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = Generator::uuid4()->toString();
            } catch (BuilderNotFoundException $ex) {
                abort(500, $ex->getMessage());
            }
        });
    }
}
