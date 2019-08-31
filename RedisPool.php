<?php


require_once __DIR__.'/AbstractPool.php';

class RedisPool extends AbstractPool
{
    protected function createDb()
    {
        $redis = new Swoole\Coroutine\Redis();
        $redis->connect($this->dbConfig['host'], $this->dbConfig['port']);
    }
}