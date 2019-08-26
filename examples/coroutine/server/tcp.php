<?php

use Swoole\Coroutine\Server;
use Swoole\Coroutine\Server\Connection;

$scheduler = new \Co\Scheduler();

$scheduler->add(function () {
    $server = new Server('0.0.0.0', 9501, false);
    $server->set([
        'worker_num'=>4,
    ]);
    $server->handle(function (Connection $conn) use ($server){
        while (true) {
            $data = $conn->recv();
            if (!$data) {
                break;
            }
            $conn->send("hello $data");
            break;
        }
        $conn->close();
        $server->shutdown();
    });
    $server->start();
});

$scheduler->start();