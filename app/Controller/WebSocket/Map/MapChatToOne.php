<?php

namespace App\Controller\WebSocket\Map;

use App\Constant\MessageConstant;
use App\Controller\WebSocket\RoomRedisManager;
use App\MessageModel\MessageFactory;
use App\MessageModel\MText;

class MapChatToOne extends AbsMap
{

    public function work($server, $fd, $mapType, $data, $fromUid, $toUid): array
    {
        echo ('处理一对一聊天') . PHP_EOL;
        parent::work($server, $fd, $mapType, $data, $fromUid, $toUid);
        $msgType = $data['msg_type'];
        $messageModel = null;
        $toUid = $data['data']['to_uid'];
        switch ($this->actionType) {
            case MessageConstant::ACTION_TYPE_SEND_MESSAGE:
                switch ($msgType) {
                    case MessageConstant::MSG_TYPE_TEXT:
                        $params = [$data['data']['text']];
                        break;
                }
                break;
        }
        $msgData = MessageFactory::createMessage($msgType, ...$params);
        $this->fdArr = RoomRedisManager::getFdByUserId($toUid);
        return $msgData;
    }
}