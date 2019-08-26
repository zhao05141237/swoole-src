<?php
$serv = new swoole_http_server("127.0.0.1", 9501);
$serv->set(array(
    'worker_num' => 1,
    'task_worker_num' => 1,
//    'task_ipc_mode' => 3,
//    'message_queue_key' => 0x70001001,
    //'task_tmpdir' => '/data/task/',
));

$serv->on('Request', function (\Swoole\Http\Request $req, $resp) use ($serv)
{
//    $group = range('a','g');
//    $data = $group[rand(0,6)];
//    $data = str_repeat('A', 5);
//    $taskId  = $serv->task($data);
//    $result = $serv->taskwait($data,5);

    $uri = $req->server['request_uri'];
    if($uri == '/favicon.ico'){
        $resp->status(404);
        $resp->end();
    }

    $tasks = range('a','g');

//    $result = $serv->taskWaitMulti($tasks,5);
    $result = $serv->taskCo($tasks,10);

    $lastResult = "";

    foreach ($tasks as $index => $task) {
        $lastResult .= "{$task} result is ";
        $lastResult .= !empty($result[$index]) ? $result[$index]['info'] : 'empty';
        $lastResult .= "<br/>";
    }

    $resp->end($lastResult);

//    $serv->task($data, -1, function ($serv, $task_id, $data) use ($resp)
//    {
//        $resp->end("Task#$task_id finished." . PHP_EOL);
//    });

});
$serv->on('Task', function (swoole_server $serv, $task_id, $reactor_id, $data) {
//    echo "#{$serv->worker_id}\tonTask: [PID={$serv->worker_pid}]: task_id=$task_id, data_len=".strlen($data).".".PHP_EOL;
//    $serv->finish($data);
//    sleep(1);
    $url = "http://ai-karin.51fanli.it/karin/fanli/home-feed?uid=244380&group=57841{$data}&page=1&page_size=750&device_id=62339770959466";
    return json_decode(file_get_contents($url),true);
});

$serv->on('Finish', function (swoole_server $serv, $task_id, $data) {
    echo '11111';
    echo "Task#$task_id finished, data_len=".strlen($data).PHP_EOL;
});

$serv->on('workerStart', function($serv, $worker_id) {
//	global $argv;
//    if ($serv->taskworker)
//    {
//        swoole_set_process_name("php {$argv[0]}: task_worker");
//    }
//    else
//    {
//        swoole_set_process_name("php {$argv[0]}: worker");
//    }
});

$serv->on('workerStop', function (swoole_server $serv, $id) {
    echo "stop\n";
    var_dump($id);
});

$serv->start();
