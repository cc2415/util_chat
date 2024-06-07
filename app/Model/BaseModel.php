<?php

namespace App\Model;

class BaseModel extends Model
{

    public static function getInfoByWhere($where, $column = ['*'])
    {
       return  self::where($where)->select($column)->first();
    }

    public static function checkIsExistByWhere($where)
    {
        return self::where($where)->exists();
    }

    public static function updateByWhere($where, $data)
    {
        return self::where($where)->update($data);
    }
}