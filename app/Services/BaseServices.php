<?php

namespace App\Services;

use Hyperf\Context\Context;

class BaseServices
{
    public static function getInstance()
    {
        return new static;
    }

    public static function getLoginUserInfo()
    {
        return Context::get(BaseServices::class);
    }

    public static function setLoginUserInfo($data)
    {
        Context::set(BaseServices::class, $data);
    }
}

