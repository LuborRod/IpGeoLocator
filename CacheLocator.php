<?php


class CacheLocator implements Locator
{
    private $next, $cache, $ttl, $name;

    public function __construct(Locator $next, Cache $cache, string $name, int $ttl)
    {
        $this->next = $next;
        $this->cache = $cache;
        $this->ttl = $ttl;
        $this->name = $name;
    }

    public function locate(Ip $ip)
    {
        $key = 'location-' . $ip->getValue();
        $location = $this->cache->get($key);
        if ($location === null) {
            $location = $this->next->locate($ip);
            $this->cache->set($key, $location, $this->ttl);
        }
    }
}