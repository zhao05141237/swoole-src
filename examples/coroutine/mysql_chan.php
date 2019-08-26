<?php

use Swoole\Coroutine as co;

$chan = new chan(4);

go(function () use ($chan) {

    $db = new co\MySQL();
    $server = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'GWx=qe-5*(2S',
        'database' => 'tuniu',
    );

    echo "connect\n";
    $ret1 = $db->connect($server);
    var_dump($ret1);

    echo "prepare\n";
    $ret2 = $db->query('SELECT * FROM users WHERE id=1');
    var_dump($ret2);

    $chan->push($db);
});

go(function () use ($chan) {
    $db = $chan->pop();
    $ret2 = $db->query('SELECT * FROM users WHERE id=3');
    var_dump($ret2);
});
