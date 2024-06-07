<?php

namespace App\Controller\WebSocket;

use App\Constant\RedisConstant;
use App\Helper\RedisHelper;
use Hamcrest\Thingy;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketServer\Context;
use Hyperf\WebSocketServer\Sender;


class RoomContextManager
{
    public static function setData($name, array $data)
    {
        Context::set((string)$name, $data);
    }

    public static function getData($name): array
    {
        return Context::get((string)$name);
    }
}