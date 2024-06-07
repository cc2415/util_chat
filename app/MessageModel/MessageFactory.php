<?php

namespace App\MessageModel;

use App\Constant\MessageConstant;
use InvalidArgumentException;
use ReflectionClass;

class MessageFactory
{
    private static $messageTypeMap = [
        MessageConstant::MSG_TYPE_TEXT => MText::class,
        MessageConstant::MSG_TYPE_IMAGE => MImage::class,
        // 可以方便地在此处添加更多类型
    ];

    /**
     * @param $type
     * @param AbsMessageModel $class
     * @return array
     * @throws \Exception
     */
    public static function createMessage($type, ...$datas)
    {
        $instance = self::getTypeInstance($type, ...$datas);
        if ($instance instanceof self::$messageTypeMap[$type]) {
            $instance->setType($type);
            $data = $instance->getData();
            return $data;
            //todo 记录进数据库
        } else {
            error(1001);
        }
    }

    /**
     * 获取类型的对象
     * @param $type
     * @param ...$datas
     * @return AbsMessageModel
     * @throws \ReflectionException
     */
    public static function getTypeInstance($type, ...$datas) : AbsMessageModel
    {
        if (!isset(self::$messageTypeMap[$type])) {
            throw new InvalidArgumentException("Unsupported message type.");
        }

        $className = self::$messageTypeMap[$type];
// 使用 ReflectionClass 创建类的实例
        $reflection = new ReflectionClass($className);
        /** @var AbsMessageModel $instance */
        $instance = null;
        if ($reflection->hasMethod('__construct')) { // 确保类有构造函数
            $instance = $reflection->newInstanceArgs($datas);
        } else {
            throw new InvalidArgumentException("参数错误");
        }
        return $instance;
    }

}