<?php

namespace Modules\Shared\Services\Cache\Adapter;

use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\CacheInterface;

class RedisCache implements CacheInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        return Cache::set($key, $value, $ttl);
    }

    public function delete(string $key): bool
    {
        return Cache::delete($key);
    }

    public function clear(): bool
    {
        return Cache::clear();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        return Cache::getMultiple($keys, $default);
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        return Cache::setMultiple($values, $ttl);
    }

    public function deleteMultiple(iterable $keys): bool
    {
        return Cache::deleteMultiple($keys);
    }

    public function has(string $key): bool
    {
        return Cache::has($key);
    }
}
