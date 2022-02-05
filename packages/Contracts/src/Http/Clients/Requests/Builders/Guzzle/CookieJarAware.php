<?php

namespace Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle;

use GuzzleHttp\Cookie\CookieJarInterface;

/**
 * Cookie Jar Aware
 *
 * @see \GuzzleHttp\Cookie\CookieJarInterface
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle
 */
interface CookieJarAware
{
    /**
     * Set cookie jar
     *
     * @param CookieJarInterface|null $jar Cookie Jar instance
     *
     * @return self
     */
    public function setCookieJar(CookieJarInterface|null $jar): static;

    /**
     * Get cookie jar
     *
     * If no cookie jar has been set, this method will
     * set and return a default cookie jar, if any such
     * value is available
     *
     * @return CookieJarInterface|null cookie jar or null if none cookie jar has been set
     */
    public function getCookieJar(): CookieJarInterface|null;

    /**
     * Check if cookie jar has been set
     *
     * @return bool True if cookie jar has been set, false if not
     */
    public function hasCookieJar(): bool;

    /**
     * Get a default cookie jar value, if any is available
     *
     * @return CookieJarInterface|null A default cookie jar value or Null if no default value is available
     */
    public function getDefaultCookieJar(): CookieJarInterface|null;
}
