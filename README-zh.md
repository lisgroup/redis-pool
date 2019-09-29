# redis-pool


## Project description

Redis Pool is a Redis database connection pool developed based on PHP extended Swoole.

#### Project introduction

Cooperative Redis database connection pool based on Swoole4 implementation.

#### Instructions for Use

##### 1. composer Installation

```bash
composer require lisgroup/redis-pool
```

##### 2. Copy file startup script

Copy the sample code `demo.php` to the project directory and start the script.

```bash
php demo.php
```

##### 3. test case
         
Browser access： http://localhost:9501/


#### Document description

1. src/AbstractPool.php -- Connection pool encapsulates abstract classes
2. src/RedisPool.php -- Cooperative Redis Connection Pool
3. demo.php Example file
