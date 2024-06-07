<?php

namespace App\Controller\WebSocket\Map;

use Swoole\WebSocket\Server;

abstract class AbsMap implements MapInterface
{
    public $fdArr = [];
    public $actionType = '';
    public $mapType = '';
    public $fromUid = 0;
    public $toUid = 0;

    public function work(Server $server, $fd, $mapType, $data, $fromUid, $toUid): array
    {
        $this->fromUid = $fromUid;
        $this->toUid = $toUid;
        return [];
    }

    public function getFdArr($fd): array
    {
        // TODO: Implement getFdArr() method.
        return $this->fdArr;
    }
}