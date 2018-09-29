<?php

namespace Aedart\Contracts\Support\Helpers\Cookie;

use Illuminate\Contracts\Cookie\Factory;

/**
 * Cookie Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Cookie
 */
interface CookieAware
{
    /**
     * Set cookie
     *
     * @param Factory|null $factory Cookie Factory instance
     *
     * @return self
     */
    public function setCookie(?Factory $factory);

    /**
     * Get cookie
     *
     * If no cookie has been set, this method will
     * set and return a default cookie, if any such
     * value is available
     *
     * @see getDefaultCookie()
     *
     * @return Factory|null cookie or null if none cookie has been set
     */
    public function getCookie(): ?Factory;

    /**
     * Check if cookie has been set
     *
     * @return bool True if cookie has been set, false if not
     */
    public function hasCookie(): bool;

    /**
     * Get a default cookie value, if any is available
     *
     * @return Factory|null A default cookie value or Null if no default value is available
     */
    public function getDefaultCookie(): ?Factory;
}
