<?php
use Workerman\Worker;
require_once __DIR__ . '/Workerman/Autoloader.php';

// 创建一个websocket协议的Worker监听7272接口
$worker = new Worker("websocket://0.0.0.0:7272");

// 只启动1个进程，这样方便客户端之间传输数据
$worker->count = 1;

$uid = 0;

// 当客户端连上来时
$worker->onConnect = function ($connection) {
    global $ws_worker, $uid;
    // 为这个连接分配一个uid
    $connection->uid = ++$uid;
};

// 当客户端发送消息过来时，转发给所有人
$worker->onMessage = function ($connection, $data) {
    global $worker;
    foreach ($worker->connections as $conn) {
        $conn->send("user_{$connection->uid} said: $data");
    }
};

// 当客户端断开时，广播给所有客户端
$worker->onClose = function ($connection) {
    global $worker;
    foreach ($worker->connections as $conn) {
        $conn->send("user_{$connection->uid} logout");
    }
};

Worker::runAll();