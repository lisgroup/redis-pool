<?php
/**
 * Redis 连接池 demo
 *
 * User: lisgroup
 * Date: 19-9-10
 * Time: 10:20
 */

require_once __DIR__.'/vendor/autoload.php';

$httpServer = new swoole_http_server('0.0.0.0', 9501);
$httpServer->set(
    ['worker_num' => 1]
);
$httpServer->on("WorkerStart", function () {
    \Pool\RedisPool::getInstance()->init();
});

$httpServer->on("request", function ($request, $response) {
    $redis = null;
    $redisPool = \Pool\RedisPool::getInstance()->getConnection();
    // var_dump($redisPool);
    if (!empty($redisPool) && isset($redisPool['redis'])) {
        $redis = $redisPool['redis'];

        $res = $redis->get('name');

        \Pool\RedisPool::getInstance()->free($redisPool);
        $response->end($res ?? '');
    }
});
$httpServer->start();
