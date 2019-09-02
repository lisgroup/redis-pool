<?php


require_once __DIR__.'/AbstractPool.php';

class RedisPool extends AbstractPool
{
    protected function createDb()
    {
        $redis = new Swoole\Coroutine\Redis([
            'connect_timeout' => 1,
            'timeout' => $this->dbConfig['timeout']
        ]);
        $redis->connect($this->dbConfig['host'], $this->dbConfig['port']);
        return $redis;
    }
}