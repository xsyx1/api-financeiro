<?php

namespace App\Services;

use \Illuminate\Cache\Repository;

class CacheService
{
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function has($key)
    {
        return $this->getCache()->has($key);
    }

    public function forget($key)
    {
        return $this->getCache()->forget($key);
    }

    public function put($key, $value, $minutes = 1)
    {
        try {
            $cache = $this->getCache();
            $cache->put($key, $value, $minutes);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get($key, $default = null)
    {
        return $this->getCache()->get($key, $default);
    }
}
