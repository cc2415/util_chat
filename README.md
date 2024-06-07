# 聊天室服务

复制.env.example 为 .env 修改对应的数据库配置和redis配置

数据库初始化文件 mysql.sql

启动：php bin/hyperf.php server:watch

http端口：9501

socket端口：9502

# 测试接口文档 ：
https://apifox.com/apidoc/shared-19072099-2c5b-4f47-bd8c-7157e81a1e34/doc-4441352

# 如何添加新数据类型
在该目录，**MessageModel**
创建一个文件来继承**MessageModel/AbsMessageModel.php**
通过构造函数定义消息类型的数据结构

例：
```php
// 新增一个消息类型
// MessageModel/CustomMessage.php
namespace App\MessageModel;

class CustomMessage extends AbsMessageModel
{
    public function __construct($text,$imgUrl,$buttonText)
    {
        parent::__construct(['text' => $text, 'img_url' => $imgUrl, 'button_text' => $buttonText]);
    }
}

```
在该文件 **MessageModel/MessageFactory.php** 增加数据类型，修改变量 **$messageTypeMap**

 ```php
 
  private static $messageTypeMap = [
        MessageConstant::MSG_TYPE_TEXT => MText::class,
        MessageConstant::MSG_TYPE_IMAGE => MImage::class,
        // 可以方便地在此处添加更多类型
        'customTypeMsg'=> CustomMessage::class,
    ];

 ```

```php
// 通过工厂创建消息
$params = ['text', 'imgUrl', 'buttonText'];
$msgData = MessageFactory::createMessage('customTypeMsg', ...$params);
```

# socket请求数据说明
## 公共字段说明

**map_type**:场景类型，目前有3个
> chat_to_all 公共大厅
> chat_to_one 私聊
> chat_to_room 群聊


**action_type**:动作类型
> send_msg 发送消息



**data**: 数据内容，根据msg_type来变

## 例子
### 公共大厅
```json
{
    "map_type": "chat_to_all",
    "action_type": "send_msg",
    "data": {
        "msg_type": "text",
        "data": {
            "text": "说话的内容"
        },
        "from_uid": 1,
        "to_uid": 0
    }
}
```
### 私聊
```json
{
    "map_type": "chat_to_one",
    "action_type":"send_msg",
    "data": {
        "msg_type": "text",
        "data": {
            "to_uid":2,
            "text": "一对一说话的内容"
        },
        "from_uid": 1,
        "to_uid": 0
    }
}
```
### 群聊
```json
{
    "map_type": "chat_to_room",
    "action_type":"send_msg",
    "data": {
        "msg_type": "text",
        "data": {
            "text": "群聊说话的内容"
        },
        "group_id":1,
        "from_uid": 1,
        "to_uid": 0
    }
}
``` 
