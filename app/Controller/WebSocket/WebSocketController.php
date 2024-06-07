<?php

namespace App\Controller\WebSocket;

use App\Constant\RoomContextConstant;
use App\Controller\WebSocket\Message\MessageDispatch;
use App\Helper\JWTHelper;
use App\Model\UserModel;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Websocket\Frame;

// 9502
class WebSocketController extends BaseWebSocket implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{

    public function onClose($server, int $fd, int $reactorId): void
    {
        //todo 关闭的要从redis中去掉
        var_dump('closed');
    }

    public function onMessage($server, Frame $frame): void
    {
        echo "接收到的数据：" . PHP_EOL;
        echo $frame->data . PHP_EOL;
        if (strtolower($frame->data) == 'ping') {
            $server->push($frame->fd, 'pong');
            RoomRedisManager::updateUserLastActivityTime($frame->fd);
            return;
        }
        //接收到的数据
        $recvData = json_decode($frame->data, true);
        if (json_last_error()) {
            $server->push($frame->fd, 'json解析错误');
            return;
        }
        if (!isset($recvData['map_type']) || !isset($recvData['action_type']) || !isset($recvData['data'])) {
            $server->push($frame->fd, '数据格式错误');
            return;
        }
        // 场景分发->对应场景处理
        $resData = (new MessageDispatch())->dispatch($server, $frame->fd, $recvData['map_type'], $recvData['action_type'], $recvData['data'], $recvData['data']['from_uid'], $recvData['data']['to_uid']);
        $fdArr = $resData['fd_arr'];
        $size = 1000;
        $length = ceil(count($fdArr) / $size);
        for ($i = 1; $i <= $length; $i++) {
            $tmpFdArr = array_slice($fdArr, ($i - 1) * $size, $size);
            go(function () use ($resData, $server, $tmpFdArr) {
                foreach ($tmpFdArr as $fd) {
                    $server->push($fd, json_encode($resData['data']));
                }
            });
        }
    }

    public function onOpen($server, Request $request): void
    {
        $uid = $request->get['uid'] ?? 0;
        if (!$uid) {
            $userInfo = JWTHelper::decode($request->header['user_token'] ?? '');
        } else {
            $userInfo = UserModel::find($uid);
        }
        $userInfo['fd'] = $request->fd;
        RoomRedisManager::recordUser($request->fd, $userInfo, $userInfo['id'] ?? 0);
        $server->push($request->fd, 'Opened');
    }
}