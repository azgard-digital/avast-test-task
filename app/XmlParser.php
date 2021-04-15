<?php
declare(strict_types=1);

namespace App;

use XMLReader;

class XmlParser implements Parser
{
    private const COOKIE_NODE_NAME = 'cookie';
    private const SUBDOMAIN_NODE_NAME = 'subdomain';
    private const COOKIE_PREFIX = 'cookie';

    private Storage $storage;
    private XMLReader $reader;

    public function __construct(Storage $storage, XMLReader $reader)
    {
        $this->storage = $storage;
        $this->reader = $reader;
    }

    public function export(): iterable
    {
        while ($this->reader->read()) {

            if ($this->reader->nodeType === XmlReader::ELEMENT) {

                switch ($this->reader->name) {
                    case self::SUBDOMAIN_NODE_NAME:
                        $subdomain = $this->reader->readString();

                        if ($subdomain) {
                            $key = $this->storage->addSubdomain($subdomain);

                            if ($key !== null) {
                                yield $key;
                            }
                        }
                        break;
                    case self::COOKIE_NODE_NAME:
                        $name = $this->reader->getAttribute('name');
                        $host = $this->reader->getAttribute('host');
                        $cookie = $this->reader->readString();

                        if ($cookie && $name && $host) {
                            $key = self::COOKIE_PREFIX.':'.$name.':'.$host;
                            $this->storage->addCookie($key, $cookie);
                            yield $key;
                        }
                        break;
                }
            }
        }
    }
}