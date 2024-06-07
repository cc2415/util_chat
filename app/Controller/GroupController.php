<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Services\GroupServices;

class GroupController extends BaseController
{
    public function add()
    {
        $name = $this->request->input('name', 0);
        return $this->json(
            GroupServices::getInstance()->add($name)
        );
    }

    public function edit()
    {
        $groupId = $this->request->input('group_id', 0);
        $name = $this->request->input('name', 0);
        return $this->json(
            GroupServices::getInstance()->edit($groupId, $name)
        );
    }

    public function delete()
    {
        $groupId = $this->request->input('group_id', 0);
        return $this->json(
            GroupServices::getInstance()->delete($groupId)
        );
    }
    public function friendAdd()
    {
        $groupId = $this->request->input('group_id', 0);
        $friendUid = $this->request->input('friend_uid', 0);
        return $this->json(
            GroupServices::getInstance()->friendAdd($groupId, $friendUid)
        );
    }
    public function friendDelete()
    {
        $groupId = $this->request->input('group_id', 0);
        $friendUid = $this->request->input('friend_uid', 0);
        return $this->json(
            GroupServices::getInstance()->friendDelete($groupId, $friendUid)
        );
    }
    public function groupList()
    {
        return $this->json(
            GroupServices::getInstance()->groupList()
        );
    }
}
