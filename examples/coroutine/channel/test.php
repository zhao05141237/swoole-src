<?php

use function Co\run;

function BatchExecMethodByCo()
{
    $args = func_get_args();
    $channel = new \Swoole\Coroutine\Channel(count($args));
    foreach ($args as $key => $func) {
        Co\run(function()use($channel,$func,$key){
            $res = $func();
            $channel->push([$key=>$res]);
        });
    }
    $list = [];
    Co\run(function()use(&$list,$args,$channel){
        foreach ($args as $key => $chan) {
            $list[$key] = $channel->pop();
        }
    });
//    swoole_event_wait();
    return $list;
}
function test($value='')
{
    \Co::sleep(1);
    return "test aabb";
}
function test2($value='')
{
    \Co::sleep(2);
    return "test2 ".rand(1,10)."\n";
}
$r = BatchExecMethodByCo("test2","test","test");
var_dump($r);