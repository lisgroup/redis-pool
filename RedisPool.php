<?php
/**
 * Redis 连接池类库
 *
 * User: lisgroup
 * Date: 19-9-5
 * Time: 10:20
 */

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

    /**
     * @return \Swoole\Coroutine\Redis
     */
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