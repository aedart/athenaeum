<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Traits;

use GuzzleHttp\Cookie\CookieJarInterface;

/**
 * Cookie Jar Trait
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle\CookieJarAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Traits
 */
trait CookieJarTrait
{
    /**
     * Cookie Jar instance
     *
     * @var CookieJarInterface|null
     */
    protected ?CookieJarInterface $cookieJar = null;

    /**
     * Set cookie jar
     *
     * @param CookieJarInterface|null $jar Cookie Jar instance
     *
     * @return self
     */
    public function setCookieJar(?CookieJarInterface $jar)
    {
        $this->cookieJar = $jar;

        return $this;
    }

    /**
     * Get cookie jar
     *
     * If no cookie jar has been set, this method will
     * set and return a default cookie jar, if any such
     * value is available
     *
     * @return CookieJarInterface|null cookie jar or null if none cookie jar has been set
     */
    public function getCookieJar(): ?CookieJarInterface
    {
        if (!$this->hasCookieJar()) {
            $this->setCookieJar($this->getDefaultCookieJar());
        }
        return $this->cookieJar;
    }

    /**
     * Check if cookie jar has been set
     *
     * @return bool True if cookie jar has been set, false if not
     */
    public function hasCookieJar(): bool
    {
        return isset($this->cookieJar);
    }

    /**
     * Get a default cookie jar value, if any is available
     *
     * @return CookieJarInterface|null A default cookie jar value or Null if no default value is available
     */
    public function getDefaultCookieJar(): ?CookieJarInterface
    {
        return null;
    }
}
