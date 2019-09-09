<?php


require_once __DIR__.'/AbstractPool.php';

class RedisPool extends AbstractPool
{
    public static $instance;

    public static function getInstance()
    {
        if (!(self::$instance instanceof RedisPool)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function createDb()
    {
        $redis = new Swoole\Coroutine\Redis([
            'connect_timeout' => 1,
            'timeout' => $this->redisConfig['timeout']
        ]);
        $redis->connect($this->redisConfig['host'], $this->redisConfig['port']);
        return $redis;
    }
}