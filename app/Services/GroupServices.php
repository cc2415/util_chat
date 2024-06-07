<?php

namespace App\Services;

use App\Helper\JWTHelper;
use App\Model\FriendModel;
use App\Model\GroupModel;
use App\Model\UserGroupModel;
use App\Model\UserModel;

class GroupServices extends BaseServices
{
    public function add($name)
    {
        return GroupModel::insertGetId(['uid' => self::getLoginUserInfo()['id'], 'name' => $name, 'created_at' => time()]);
    }

    public function edit($groupId, $name)
    {
        return GroupModel::updateByWhere(['id' => $groupId], ['name' => $name, 'updated_at' => time()]);
    }

    public function delete($groupId)
    {
        return GroupModel::updateByWhere(['id' => $groupId], ['is_delete' => 1, 'updated_at' => time()]);
    }

    public function friendAdd($groupId, $friendUid)
    {
        $userInfo = self::getLoginUserInfo();
        if (UserGroupModel::checkIsExistByWhere(['uid' => $userInfo['id'], 'id' => $groupId, 'friend_uid' => $friendUid])
            || $userInfo['id'] == $friendUid) {
            error(1003);
        }
        $id = UserGroupModel::insertGetId(['group_id' => $groupId, 'uid' => $userInfo['id'], 'friend_uid' => $friendUid, 'created_at' => time()]);
        return $id;
    }

    public function friendDelete($groupId, $friendUid)
    {
        $userInfo = self::getLoginUserInfo();
        $id = UserGroupModel::updateByWhere(['group_id' => $groupId, 'uid' => $userInfo['id'], 'friend_uid' => $friendUid], ['is_delete' => 1, 'updated_at' => time()]);
        return [];
    }

    public function groupList()
    {
        $groupList = GroupModel::where(['uid' => self::getLoginUserInfo()['id'], 'is_delete' => 0])->get()->toArray();
        $data = [];
        foreach ($groupList as $itemGroup) {

            $groupFriendList = UserGroupModel::leftJoin('user', 'user.id', '=', 'user_group.friend_uid')->where(['user_group.group_id' => $itemGroup['id']])
                ->select(['user.name', 'user.id', 'user_group.group_id'])->get()->toArray();
            $data[] = [
                'group_id' => $itemGroup['id'],
                'group_name' => $itemGroup['name'],
                'friend_list' => $groupFriendList
            ];
        }
        return $data;
    }

}