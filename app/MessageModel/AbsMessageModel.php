<?php

namespace App\MessageModel;
/**
 * 消息抽象类
 */
abstract class AbsMessageModel implements MessageInterface
{
    public $type;
    public $data;
    public $actionType;
    public $mapType;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return ['msg_type' => $this->type, 'data' => $this->data,];
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

}