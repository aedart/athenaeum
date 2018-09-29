<?php

namespace Aedart\Contracts\Support\Helpers\Cookie;

use Illuminate\Contracts\Cookie\QueueingFactory;

/**
 * Queueing Cookie Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Cookie
 */
interface QueueingCookieAware
{
    /**
     * Set queueing cookie
     *
     * @param QueueingFactory|null $factory Queueing Cookie Factory instance
     *
     * @return self
     */
    public function setQueueingCookie(?QueueingFactory $factory);

    /**
     * Get queueing cookie
     *
     * If no queueing cookie has been set, this method will
     * set and return a default queueing cookie, if any such
     * value is available
     *
     * @see getDefaultQueueingCookie()
     *
     * @return QueueingFactory|null queueing cookie or null if none queueing cookie has been set
     */
    public function getQueueingCookie(): ?QueueingFactory;

    /**
     * Check if queueing cookie has been set
     *
     * @return bool True if queueing cookie has been set, false if not
     */
    public function hasQueueingCookie(): bool;

    /**
     * Get a default queueing cookie value, if any is available
     *
     * @return QueueingFactory|null A default queueing cookie value or Null if no default value is available
     */
    public function getDefaultQueueingCookie(): ?QueueingFactory;
}
