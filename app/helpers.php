<?php
function error($code = 0, $msg = '' ){
    throw new \Exception($msg?:\App\Constant\ErrCode::$CODE[$code], $code);
}
function webSocketContextGet($name){
    return \Hyperf\WebSocketServer\Context::get($name);
}
function webSocketContextSet($name, $data){
    return \Hyperf\WebSocketServer\Context::set($name, $data);
}