<?php
declare(strict_types=1);

namespace App;

use Redis as Instance;

class Redis
{
    private const DEFAULT_HOST = 'localhost';
    private const DEFAULT_PORT = 6379;
    private Instance $redis;

    public function __construct()
    {
        $this->redis = new Instance();
    }

    public function connect(): Instance
    {
        $host = getenv('REDIS_HOST', true) ?? self::DEFAULT_HOST;
        $port = getenv('REDIS_PORT', true) ?? self::DEFAULT_PORT;

        if ($this->redis->connect($host, (int) $port)) {
            return $this->redis;
        }

        throw new \Exception('Cannot connect to redis');
    }
}