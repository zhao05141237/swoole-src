<?php
go(function () {

$redis = new Swoole\Coroutine\Redis();
$redis->connect('127.0.0.1', 6379);
$i = 0;
while (true) 
{
	$msg = $redis->publish('msg_1', 'hello-' . $i++);
	var_dump($msg);
	co::sleep(1);
}

});
