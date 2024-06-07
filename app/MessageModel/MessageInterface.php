<?php

namespace App\MessageModel;
/**
 * 消息接口
 */
interface MessageInterface
{
    function getData();

    function getType();

    function setType($type);
}