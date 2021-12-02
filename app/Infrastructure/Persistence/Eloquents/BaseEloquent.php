<?php
namespace App\Infrastructure\Persistence\Eloquents;


use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

abstract class BaseEloquent extends Model
{
    protected $primaryKey = 'id';


    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getCreatedAt()
    {
        $format = Config::get('datetime.format.database_datetime');

        return $this->created_at->format($format);
    }

    public function getUpdatedAt()
    {
        $format = Config::get('datetime.format.database_datetime');

        return $this->updated_at->format($format);
    }

    public function getDeletedAt()
    {
        $format = Config::get('datetime.format.database_datetime');

        return $this->deleted_at->format($format);
    }

    public function setCreatedInfo(string $requestBy)
    {
        $date = new DateTime('now');

        $this->created_by = $requestBy;
        $this->created_at = $date->format(Config::get('datetime.format.database_datetime'));
    }

    public function setUpdatedInfo(string $requestBy)
    {
        $date = new DateTime('now');

        $this->updated_by = $requestBy;
        $this->updated_at = $date->format(Config::get('datetime.format.database_datetime'));
    }

    public function validate(array $rules, object $request)
    {
        return Validator::make((array)$request, $rules);
    }
}
