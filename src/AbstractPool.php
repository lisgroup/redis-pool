<?php
/**
 * 连接池抽象类库
 *
 * User: lisgroup
 * Date: 19-8-25
 * Time: 10:20
 */

namespace Pool;

use Swoole\Coroutine\Channel;

abstract class AbstractPool
{
    private $min; // 连接池最小数量
    private $max; // 连接池最大数量
    private $count; // 当前连接数
    private $connections; // 连接池组
    protected $spareTime; // 用于空闲连接回收判断
    // 数据库配置
    protected $redisConfig = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'selectDb' => 0,
        'timeout' => 3,
    ];

    private $inited = false;

    protected abstract function createPool();

    public function __construct()
    {
        $this->min = 10;
        $this->max = 100;
        $this->spareTime = 10 * 3600;
        $this->connections = new Channel($this->max + 1);
    }

    protected function createObject()
    {
        $obj = null;
        $redis = $this->createPool();
        if ($redis) {
            $obj = [
                'last_used_time' => time(),
                'redis' => $redis,
            ];
        }
        return $obj;
    }

    /**
     * 初始换最小数量连接池
     *
     * @return $this|null
     */
    public function init()
    {
        if ($this->inited) {
            return null;
        }
        for ($i = 0; $i < $this->min; $i++) {
            $obj = $this->createObject();
            $this->count++;
            $this->connections->push($obj);
        }
        return $this;
    }

    /**
     * 获取连接
     *
     * @param int $timeOut
     *
     * @return array|mixed|null
     */
    public function getConnection($timeOut = 3)
    {
        $obj = null;
        if ($this->connections->isEmpty()) {
            if ($this->count < $this->max) {
                // 连接数没到最大，新建连接池
                $this->count++;
                $obj = $this->createObject();#1
            } else {
                $obj = $this->connections->pop($timeOut);#2
            }
        } else {
            $obj = $this->connections->pop($timeOut);#3
        }
        return $obj;
    }

    /**
     * 释放
     *
     * @param $object
     */
    public function free($object)
    {
        if ($object) {
            $this->connections->push($object);
        }
    }

    /**
     * 处理空闲连接
     */
    public function gcSpareObject()
    {
        // 2 分钟检测一次连接
        swoole_timer_tick(120000, function () {
            $list = [];
            /*echo "开始检测回收空闲链接" . $this->connections->length() . PHP_EOL;*/
            if ($this->connections->length() < intval($this->max * 0.5)) {
                echo '请求连接数较多，不需要回收连接'.PHP_EOL;
            }#1
            while (true) {
                if (!$this->connections->isEmpty()) {
                    $obj = $this->connections->pop(0.001);
                    $last_used_time = $obj['last_used_time'];
                    if ($this->count > $this->min && (time() - $last_used_time > $this->spareTime)) {
                        // 回收
                        $this->count--;
                    } else {
                        array_push($list, $obj);
                    }
                } else {
                    break;
                }
            }
            foreach ($list as $item) {
                $this->connections->push($item);
            }
            unset($list);
        });
    }
}
