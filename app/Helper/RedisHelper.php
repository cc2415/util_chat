<?php

namespace App\Helper;

use Hyperf\Utils\ApplicationContext;

class RedisHelper
{
    private static $instance = null;

    public static function getInstance(): \Hyperf\Redis\Redis
    {
        if (self::$instance === null) {

            $container = ApplicationContext::getContainer();
            self::$instance = $container->get(\Hyperf\Redis\Redis::class);
        }
        return self::$instance;
    }
}