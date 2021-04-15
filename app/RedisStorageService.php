<?php
declare(strict_types=1);

namespace App;

use Redis;

class RedisStorageService implements Storage
{
    private const SUBDOMAIN_STORAGE_KEY = 'subdomains';

    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function addSubdomain(string $value): ?int
    {
        $len = $this->redis->rpush(self::SUBDOMAIN_STORAGE_KEY, $value);

        if ($len) {
            return $len - 1;
        }

        return null;
    }

    public function addCookie(string $key, string $value): void
    {
        $this->redis->set($key, $value);
    }
}