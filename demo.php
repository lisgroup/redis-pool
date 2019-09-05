<?php

require_once __DIR__.'/RedisPool.php';

$httpServer = new swoole_http_server('0.0.0.0', 9501);
$httpServer->set(
    ['worker_num' => 1]
);
$httpServer->on("WorkerStart", function () {
});

$httpServer->on("request", function ($request, $response) {
});
$httpServer->start();
