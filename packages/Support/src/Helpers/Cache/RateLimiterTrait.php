<?php

namespace Aedart\Support\Helpers\Cache;

use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\RateLimiter as RateLimiterFacade;

/**
 * Rate Limiter Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Cache\RateLimiterAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Cache
 */
trait RateLimiterTrait
{
    /**
     * Rate Limiter instance
     *
     * @var RateLimiter|null
     */
    protected RateLimiter|null $rateLimiter = null;

    /**
     * Set rate limiter
     *
     * @param \Illuminate\Cache\RateLimiter|null $limiter Rate Limiter instance
     *
     * @return self
     */
    public function setRateLimiter($limiter): static
    {
        $this->rateLimiter = $limiter;

        return $this;
    }

    /**
     * Get rate limiter
     *
     * If no rate limiter has been set, this method will
     * set and return a default rate limiter, if any such
     * value is available
     *
     * @return \Illuminate\Cache\RateLimiter|null rate limiter or null if none rate limiter has been set
     */
    public function getRateLimiter()
    {
        if (!$this->hasRateLimiter()) {
            $this->setRateLimiter($this->getDefaultRateLimiter());
        }
        return $this->rateLimiter;
    }

    /**
     * Check if rate limiter has been set
     *
     * @return bool True if rate limiter has been set, false if not
     */
    public function hasRateLimiter(): bool
    {
        return isset($this->rateLimiter);
    }

    /**
     * Get a default rate limiter value, if any is available
     *
     * @return \Illuminate\Cache\RateLimiter|null A default rate limiter value or Null if no default value is available
     */
    public function getDefaultRateLimiter()
    {
        return RateLimiterFacade::getFacadeRoot();
    }
}