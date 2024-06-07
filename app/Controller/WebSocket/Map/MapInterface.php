<?php

namespace App\Controller\WebSocket\Map;

use Swoole\WebSocket\Server;

interface MapInterface
{
    public function work(Server $server, $fd, $mapType, $data, $fromUid, $toUid): array;

    public function getFdArr($fd): array;
}