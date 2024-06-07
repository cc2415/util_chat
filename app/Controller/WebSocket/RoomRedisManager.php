<?php

namespace App\Controller\WebSocket;

use App\Constant\RedisConstant;
use App\Helper\RedisHelper;
use Hamcrest\Thingy;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketServer\Sender;


class RoomRedisManager
{
    /**
     * @Inject
     * @var Sender
     */
    protected $sender;

    public static function recordUser($fd, $data = [], $userId = 0)
    {
        $data['open_time'] = time();
        $data['last_activity_time'] = time();
        $data['open_time_str'] = date('Y-m-d H:i:s');
        $key = "{$fd}_{$userId}";
        RedisHelper::getInstance()->hSet(RedisConstant::ROOM, $key, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更新最后活动时间
     * @param $fd
     * @return void
     */
    public static function updateUserLastActivityTime($fd)
    {
        $data = self::getUserByFd($fd);
        $key = $data['key'];
        $data['info']['last_activity_time'] = time();
        RedisHelper::getInstance()->hSet(RedisConstant::ROOM, $key, json_encode($data['info'], JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取所有的用户信息
     * @param bool $onlyFd 只返回fd
     * @return array
     */
    public static function getAllUser(bool $onlyFd = true)
    {
        $fdList = RedisHelper::getInstance()->hGetAll(RedisConstant::ROOM);
        if ($onlyFd) {
            $fdArr = [];
            $keyArr = array_keys($fdList);
            array_map(function ($item) use (&$fdArr) {
                $fdArr[] = explode('_', $item)[0];
            }, $keyArr);
            return array_unique($fdArr);
        }
        return $fdList;
    }

    /**
     * 根据用户id取得fd
     * @param $userId
     * @return array
     */
    public static function getFdByUserId($userId)
    {
        $fdList = RedisHelper::getInstance()->hGetAll(RedisConstant::ROOM);
        $fdArr = [];
        foreach ($fdList as $key => $item) {
            $keyArr = explode('_', $key);
            $keyUserId = $keyArr[1] ?? null;
            if ($keyUserId === null) {
                continue;
            }
            if ($userId == $keyUserId) {
                $fdArr[] = $keyArr[0];
            }
        }
        return $fdArr;
    }

    /**
     * 根据用户id取得fd
     * @param array $userIdArr
     * @return array
     */
    public static function getFdByUserIds(array $userIdArr): array
    {
        $fdList = RedisHelper::getInstance()->hGetAll(RedisConstant::ROOM);
        $fdArr = [];
        foreach ($fdList as $key => $item) {
            $keyArr = explode('_', $key);
            $keyUserId = $keyArr[1] ?? null;
            if ($keyUserId === null) {
                continue;
            }
            if (in_array($keyUserId, $userIdArr)) {
                $fdArr[] = $keyArr[0];
            }
        }
        return array_unique($fdArr);
    }

    /**
     * 根据fd获取用户信息
     * @param $fd
     * @return array
     */
    public static function getUserByFd($fd): array
    {
        $fdList = RedisHelper::getInstance()->hGetAll(RedisConstant::ROOM);
        foreach ($fdList as $key => $item) {
            $keyArr = explode('_', $key);
            $keyFd = $keyArr[0] ?? null;
            if ($keyFd === null) {
                continue;
            }
            if ($fd == $keyFd) {
                return ['key' => $key, 'info' => json_decode($item, true)];
            }
        }
        return [];
    }

    private function getSender(): Sender
    {
        return $this->sender;
    }

    /**
     * 清除不活动的链接
     * @return void
     */
    public static function clearnNotActivityFd()
    {
        echo '清除不活动的链接' . PHP_EOL;
        $fdList = self::getAllUser(false);
        $now = time();
        foreach ($fdList as $fd => $item) {
            $item = json_decode($item, true);
            if ($item['last_activity_time'] < ($now - 600)) {
                RedisHelper::getInstance()->hDel(RedisConstant::ROOM, $fd);
            }
        }
    }
}