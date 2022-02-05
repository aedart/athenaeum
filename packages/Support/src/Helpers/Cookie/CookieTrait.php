<?php

namespace Aedart\Support\Helpers\Cookie;

use Illuminate\Contracts\Cookie\Factory;
use Illuminate\Support\Facades\Cookie;

/**
 * Cookie Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Cookie\CookieAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Cookie
 */
trait CookieTrait
{
    /**
     * Cookie Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $cookie = null;

    /**
     * Set cookie
     *
     * @param Factory|null $factory Cookie Factory instance
     *
     * @return self
     */
    public function setCookie(Factory|null $factory): static
    {
        $this->cookie = $factory;

        return $this;
    }

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
    public function getCookie(): Factory|null
    {
        if (!$this->hasCookie()) {
            $this->setCookie($this->getDefaultCookie());
        }
        return $this->cookie;
    }

    /**
     * Check if cookie has been set
     *
     * @return bool True if cookie has been set, false if not
     */
    public function hasCookie(): bool
    {
        return isset($this->cookie);
    }

    /**
     * Get a default cookie value, if any is available
     *
     * @return Factory|null A default cookie value or Null if no default value is available
     */
    public function getDefaultCookie(): Factory|null
    {
        return Cookie::getFacadeRoot();
    }
}
