<?php


require_once __DIR__.'/AbstractPool.php';

class RedisPool extends AbstractPool
{
    protected function createDb()
    {
        $redis = new Swoole\Coroutine\Redis();
        $redis->connect('127.0.0.1', 6379);
    }
}