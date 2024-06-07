<?php

namespace App\Controller\WebSocket\Map;

use App\Constant\MessageConstant;
use App\Controller\WebSocket\RoomRedisManager;
use App\MessageModel\MessageFactory;
use App\MessageModel\MText;

class MapChatToAll extends AbsMap
{

    public function work($server, $fd, $mapType, $data, $fromUid, $toUid): array
    {
        echo ('处理公共聊天室消息') . PHP_EOL;
        parent::work($server, $fd, $mapType, $data, $fromUid, $toUid);
        $msgType = $data['msg_type'];
        switch ($msgType) {
            case MessageConstant::MSG_TYPE_TEXT:
                $params = [$data['data']['text']];
                break;
        }
        $msgData = MessageFactory::createMessage($msgType, ...$params);
        $this->fdArr = RoomRedisManager::getAllUser();
        return $msgData;
    }
}