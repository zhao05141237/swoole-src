<?php
go(function () {
    $count = 0;
    $cid = co::getCid();
    go(function () use (&$count) {
        $cid = co::getCid();
        echo "{$cid} {$count}\n";
        echo "task {$cid} start\n";
        co::sleep(0.5);
        co::resume(1);
        echo "task {$cid} resume count $count\n";
        echo "task {$cid} end\n";
    });
    go(function () use (&$count) {
        $cid = co::getCid();
        echo "{$cid} {$count}\n";
        echo "task {$cid} start\n";
        co::sleep(0.9);
        echo "task {$cid} resume count $count\n";
        echo "task {$cid} end\n";
    });
    echo $cid.' '.$count."\n";
    co::suspend();
//    co::resume(1);
});
echo "main \n";
