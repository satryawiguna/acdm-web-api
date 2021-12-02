<?php
namespace App\Core\Domain\Contracts;


interface IBaseEntity
{
    public function getKey();

    public function getTable();

    public function getAttribute($attribute);

    public function setAttribute($attribute, $value);

    public function toJson(int $options = 0);

    public function toArray();
}
