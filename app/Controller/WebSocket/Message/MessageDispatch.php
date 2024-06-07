<?php

namespace App\Controller\WebSocket\Message;

use App\Constant\MessageConstant;
use App\Controller\WebSocket\Map\AbsMap;
use App\Controller\WebSocket\Map\MapChatToAll;
use App\Controller\WebSocket\Map\MapChatToOne;
use App\Controller\WebSocket\Map\MapChatToRoom;
use InvalidArgumentException;
use Swoole\WebSocket\Server;

class MessageDispatch
{
    /** @var string[] 场景分发 */
    const DISPATCH_MAP = [
        MessageConstant::MAP_TYPE_CHAT_ALL => MapChatToAll::class,
        MessageConstant::MAP_TYPE_CHAT_TO_ONE => MapChatToOne::class,
        MessageConstant::MAP_TYPE_CHAT_TO_ROOM => MapChatToRoom::class,
    ];

    /**
     * @param Server $server
     * @param $fd
     * @param $mapType
     * @param $data
     * @return array
     */
    public function dispatch(Server $server, $fd, $mapType, $actionType, $data, $fromUid, $toUid)
    {
        if (!isset(self::DISPATCH_MAP[$mapType])) {
            throw new InvalidArgumentException("非法场景");
        }
        /** @var AbsMap $instance */
        $class = self::DISPATCH_MAP[$mapType];
        $instance = new $class();
        $instance->actionType = $actionType;
        $instance->mapType = $mapType;
        return [
            'data' => [
                'map_type' => $mapType,
                'action_type' => $actionType,
                'data' => array_merge($instance->work($server, $fd, $mapType, $data, $fromUid, $toUid), ['from_uid' => $fromUid, 'to_uid' => $toUid]),
                'extend' => new \stdClass(),
            ],
            'fd_arr' => empty($instance->getFdArr($fd)) ? [$fd] : $instance->getFdArr($fd),
        ];
    }
}