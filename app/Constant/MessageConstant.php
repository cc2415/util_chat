<?php

namespace App\Constant;

class MessageConstant
{
    /**
     * 场景 start
     */
    /** @var string 公共聊天室 */
    const MAP_TYPE_CHAT_ALL = 'chat_to_all';
    /** @var int 一对一聊天 */
    const MAP_TYPE_CHAT_TO_ONE = 'chat_to_one';
    /** @var int 群聊 */
    const MAP_TYPE_CHAT_TO_ROOM = 'chat_to_room';
    /**
     * 场景 end
     */

    /**
     * 动作 start
     */
    /** @var string 动作：发送消息 */
    const ACTION_TYPE_SEND_MESSAGE = 'send_msg';
    /**
     * 动作 end
     */

    /** @var string 文本 */
    const MSG_TYPE_TEXT = 'text';
    /** @var string 图片 */
    const MSG_TYPE_IMAGE = 'image';

}