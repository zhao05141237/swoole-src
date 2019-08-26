<?php

go(function(){
    $db = new Swoole\Coroutine\Mysql;
    $server = [
        'host'     => 'unix:/tmp/mysql.sock',
        'user' => 'root',
        'password' => 'GWx=qe-5*(2S',
        'database' => 'tuniu',
    ];
    $db->connect($server);
    $stmt = $db->prepare('SELECT * FROM `users` WHERE id=?');
    var_dump($stmt);
    if ($stmt == false){
        var_dump($db->errno,$db->error);
        return ;
    }
    $ret = $stmt->execute([1]);
    var_dump($ret);
});
