<?php

namespace App\Services;

use App\Helper\JWTHelper;
use App\Model\FriendModel;
use App\Model\UserModel;

class UserServices extends BaseServices
{
    /**
     * 注册
     * @param $name
     * @param $passWord
     * @return mixed
     * @throws \Exception
     */
    public function userRegister($name, $passWord)
    {
        $data = [];
        //判断账号是否存在
        if (UserModel::checkIsExistByWhere(['name' => $name])) {
            error(4001);
        }
        UserModel::insert(['name' => $name, 'password' => md5($passWord)]);
        return $name;
    }


    /**
     * 登陆
     * @param $name
     * @param $passWord
     * @return array
     * @throws \Exception
     */
    public function userLogin($name, $passWord)
    {
        $data = [];
        if ($res = UserModel::getInfoByWhere(['name' => $name, 'password' => md5($passWord)])) {
            $data['name'] = $name;
            $data['token'] = JWTHelper::encode($res);
        } else {
            error(4003);
        }
        return $data;
    }

    /**
     * 检查更新token
     * @param $token
     * @return mixed
     */
    public function checkToken($token)
    {
        $data = JWTHelper::decode($token);
        $data['token'] = $token;
        if ($data) {
            $user = UserModel::getInfoByWhere(['id' => $data['id']]);
            $token = JWTHelper::encode($user);
            $data['token'] = $token;
        }
        unset($data['password']);
        return $data;
    }

    public function friendList()
    {
        $userInfo = self::getLoginUserInfo();
        var_dump($userInfo['id']);
        $list = FriendModel::leftJoin('user', 'user.id', 'friend.friend_uid')
            ->where(['uid' => $userInfo['id'], 'is_delete' => 0])
            ->select(['user.name as friend_name', 'friend.friend_uid'])->get()->toArray();
        return $list;

    }

    public function friendFind($name)
    {
        $list = UserModel::where('name', 'like', "{$name}%")->select(['name', 'id'])->get()->toArray();
        return $list;

    }

    public function friendAdd($uid)
    {
        $userInfo = self::getLoginUserInfo();
        if (FriendModel::checkIsExistByWhere(['uid' => $userInfo['id'], 'friend_uid' => $uid])
            || $userInfo['id'] == $uid) {
            error(1003);
        }
        $id = FriendModel::insertGetId(['uid' => $userInfo['id'], 'friend_uid' => $uid, 'created_at' => time()]);
        return $id;
    }

    public function friendDelete($uid)
    {
        $userInfo = self::getLoginUserInfo();
        if (!FriendModel::checkIsExistByWhere(['uid' => $userInfo['id'], 'friend_uid' => $uid])
            || $userInfo['id'] == $uid) {
            error(1003);
        }
        $id = FriendModel::updateByWhere(['uid' => $userInfo['id'], 'friend_uid' => $uid], ['is_delete' => 1, 'updated_at' => time()]);
        return [];
    }

}