# redis-pool

## 项目说明
Redis Pool 是基于 PHP 扩展 Swoole 开发的 Redis 数据库连接池。

#### 项目介绍
基于 Swoole4 实现的协程 Redis 数据库连接池


#### 使用说明

##### 1. composer 安装

```bash
composer require lisgroup/redis-pool
```

##### 2. 复制文件启动脚本

复制示例代码 `demo.php` 到项目目录，启动脚本

```bash
php demo.php
```

##### 3. 测试用例

浏览器访问： http://localhost:9501/


#### 文件说明

1. src/AbstractPool.php 连接池封装抽象类
2. src/RedisPool.php 协程 Redis 连接池
3. demo.php 示例文件
