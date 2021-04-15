<?php
declare(strict_types=1);

use App\Redis;
use App\RedisStorageService;
use App\XmlParser;
use PHPUnit\Framework\TestCase;

class XmlParserTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testXmlStore(string $data)
    {
        $redis = (new Redis())->connect();
        $storage = new RedisStorageService($redis);
        $reader = \XMLReader::XML($data);
        $parser = new XmlParser($storage, $reader);

        foreach ($parser->export() as $key) {
            $this->assertNotNull($key);
        }

        $lenSubdomain = $redis->lLen('subdomains');
        $this->assertGreaterThanOrEqual(2, $lenSubdomain);

        $key = 'cookie:dlp-avast:amazon';
        $value = 'mmm_amz_dlp_777_ppc_m';
        $cookie = $redis->get($key);
        $this->assertSame($value, $cookie);

        $key = 'cookie:dlp-avast:baixaki';
        $value = 'mmm_bxk_dlp_777_ppc_m';
        $cookie = $redis->get($key);
        $this->assertSame($value, $cookie);
    }

    public function additionProvider(): array
    {
        $xml = '<config>
    <subdomains>
        <subdomain>http://secureline.tools.avast.com</subdomain>
        <subdomain>http://gf.tools.avast.com</subdomain>
    </subdomains>

    <cookies>
        <!-- avast -->
        <cookie name="dlp-avast" host="amazon">mmm_amz_dlp_777_ppc_m</cookie>
        <cookie name="dlp-avast" host="baixaki">mmm_bxk_dlp_777_ppc_m</cookie>
    </cookies>
</config>';

        return [
            [$xml]
        ];
    }
}