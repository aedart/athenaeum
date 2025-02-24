<?php

namespace Aedart\Contracts\Support\Helpers\Cache;

/**
 * Rate Limiter Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Cache
 */
interface RateLimiterAware
{
    /**
     * Set rate limiter
     *
     * @param \Illuminate\Cache\RateLimiter|null $limiter Rate Limiter instance
     *
     * @return self
     */
    public function setRateLimiter($limiter): static;

    /**
     * Get rate limiter
     *
     * If no rate limiter has been set, this method will
     * set and return a default rate limiter, if any such
     * value is available
     *
     * @return \Illuminate\Cache\RateLimiter|null rate limiter or null if none rate limiter has been set
     */
    public function getRateLimiter();

    /**
     * Check if rate limiter has been set
     *
     * @return bool True if rate limiter has been set, false if not
     */
    public function hasRateLimiter(): bool;

    /**
     * Get a default rate limiter value, if any is available
     *
     * @return \Illuminate\Cache\RateLimiter|null A default rate limiter value or Null if no default value is available
     */
    public function getDefaultRateLimiter();
}
