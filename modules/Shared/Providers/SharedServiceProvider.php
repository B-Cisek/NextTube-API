<?php

namespace Modules\Shared\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Services\Cache\Adapter\RedisCache;
use Psr\SimpleCache\CacheInterface;

class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CacheInterface::class, RedisCache::class);
    }

    public function boot(): void {}
}
