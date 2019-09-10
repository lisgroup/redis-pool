<?php

require_once __DIR__.'/RedisPool.php';

$httpServer = new swoole_http_server('0.0.0.0', 9501);
$httpServer->set(
    ['worker_num' => 1]
);
$httpServer->on("WorkerStart", function () {
    RedisPool::getInstance()->init();
});

$httpServer->on("request", function ($request, $response) {
    $redis = null;
    $redisPool = RedisPool::getInstance()->getConnection();
    // var_dump($redisPool);
    if (!empty($redisPool) && isset($redisPool['redis'])) {
        $redis = $redisPool['redis'];

        $res = $redis->get('name');
        $response->end($res ?? 'NULL');
    }
});
$httpServer->start();
