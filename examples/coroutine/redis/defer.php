<?php

const REDIS_SERVER_HOST = '127.0.0.1';
const REDIS_SERVER_PORT = 6379;


go(function () {
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect(REDIS_SERVER_HOST, REDIS_SERVER_PORT);

    $redis->setDefer();
    $list = range(1,10);
    foreach ($list as $item) {
        $redis->setex('key'.$item,300,'value'.$item);
        $redis->get('key'.$item);
    }
//    $redis->set('key1', 'value');

//    $redis2 = new Swoole\Coroutine\Redis();
//    $redis2->connect(REDIS_SERVER_HOST, REDIS_SERVER_PORT);
//    $redis2->setDefer();
//    $redis->get('key1');

//    $result1 = $redis->recv();
//    $result2 = $redis->recv();
    foreach ($list as $item) {
        var_dump($redis->recv(),$redis->recv());
    }

//    var_dump($result1, $result2);
});


