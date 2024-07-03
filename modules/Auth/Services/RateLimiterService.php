<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\RateLimiter;
use Modules\Auth\Exceptions\ThrottleException;

final class RateLimiterService
{
    /**
     * @throws ThrottleException
     */
    public function ensureIsNotRateLimited(string $key, int $maxAttempts): void
    {
        if (! RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw new ThrottleException('Too many attempts. Please try again in '.$seconds.' seconds.');
    }

    public function hit(string $key): void
    {
        RateLimiter::hit($key);
    }

    public function clear(string $key): void
    {
        RateLimiter::clear($key);
    }
}
