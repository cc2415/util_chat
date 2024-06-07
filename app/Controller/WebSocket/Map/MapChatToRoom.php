<?php

namespace App\Controller\WebSocket\Map;

use App\Constant\MessageConstant;
use App\Controller\WebSocket\RoomRedisManager;
use App\MessageModel\MessageFactory;
use App\MessageModel\MText;
use App\Model\UserGroupModel;

class MapChatToRoom extends AbsMap
{

    public function work($server, $fd, $mapType, $data, $fromUid, $toUid): array
    {
        echo ('处理群聊消息') . PHP_EOL;
        parent::work($server, $fd, $mapType, $data, $fromUid, $toUid);
        $msgType = $data['msg_type'];
        $groupId = $data['group_id'];
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
        $userGroupUidArr = UserGroupModel::where(['group_id' => $groupId])->pluck('uid')->toArray();
        $this->fdArr = RoomRedisManager::getFdByUserIds($userGroupUidArr);
        var_dump($this->fdArr, $userGroupUidArr);
        return $msgData;
    }
}