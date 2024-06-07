<?php

namespace App\Controller;

use App\MessageModel\MessageFactory;
use App\MessageModel\MImage;
use App\MessageModel\MText;
use App\Services\UserServices;

class UserController extends BaseController
{
    /**
     * 游客登陆
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function touristLogin()
    {
        $userName = $this->request->input('name');
        $passWord = $this->request->input('password');
        if (!$userName || !$passWord) {
            error(4002);
        }
        return $this->json(
            UserServices::getInstance()->userRegister($userName, $passWord)
        );
    }

    /**
     * 用户注册
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function userRegister()
    {
        $userName = $this->request->input('name');
        $passWord = $this->request->input('password');
        if (!$userName || !$passWord) {
            error(4002);
        }
        return $this->json(
            UserServices::getInstance()->userRegister($userName, $passWord)
        );
    }

    /**
     * 用户登陆
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function userLogin()
    {
        $userName = $this->request->input('name');
        $passWord = $this->request->input('password');
        $token = $this->request->input('token');
        if (!$userName || !$passWord) {
            error(4002);
        }
        return $this->json(
            UserServices::getInstance()->userLogin($userName, $passWord, $token)
        );
    }

    /**
     * 检查/刷新 token
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function checkToken()
    {
        MessageFactory::createMessage(MessageFactory::$TYPE_TEXT, new MImage('dizhi', 'biaoti'));
        MessageFactory::createMessage(MessageFactory::$TYPE_TEXT, new MText('wenben'));
        $token = $this->request->input('token');
        if (!$token) {
            error(4002);
        }
        return $this->json(
            UserServices::getInstance()->checkToken($token)
        );
    }

    public function friendList()
    {
        return $this->json(
            UserServices::getInstance()->friendList()
        );
    }

    /**
     * 查找朋友
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function friendFind()
    {
        $name = $this->request->input('name', '');
        return $this->json(
            UserServices::getInstance()->friendFind($name)
        );
    }

    /**
     * 添加朋友
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function friendAdd()
    {
        $uid = $this->request->input('uid', 0);
        return $this->json(
            UserServices::getInstance()->friendAdd($uid)
        );
    }

    /**
     * 删除朋友
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function friendDelete()
    {
        $uid = $this->request->input('uid', 0);
        return $this->json(
            UserServices::getInstance()->friendDelete($uid)
        );
    }
}