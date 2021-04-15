<?php
declare(strict_types=1);

use App\Redis;
use App\RedisStorageService;
use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{
    public function testSubdomanStore()
    {
        $redis = (new Redis())->connect();
        $storage = new RedisStorageService($redis);
        $key = $storage->addSubdomain('test.com.loc');
        $this->assertIsInt($key);
        $subdomain = $redis->lRange('subdomains', $key, $key);
        $this->assertSame('test.com.loc', $subdomain[0]);
    }

    public function testCookieStore()
    {
        $redis = (new Redis())->connect();
        $storage = new RedisStorageService($redis);
        $key = 'cookie:dlp-avast:amazon';
        $value = 'mmm_amz_dlp_777_ppc_m';
        $storage->addCookie($key, $value);
        $cookie = $redis->get($key);
        $this->assertSame($value, $cookie);
    }
}