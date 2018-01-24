<?php
use Workerman\Worker;
require_once __DIR__ . '/Workerman/Autoloader.php';

// 注意：这里与上个例子不通，使用的是websocket协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 当收到客户端发来的数据后返回 数据给客户端
$ws_worker->onMessage = function($connection, $data) {
    // 向客户端发送 你的名字叫： $data
    $connection->send('你的名字叫：' . $data);
};

// 运行worker
Worker::runAll();