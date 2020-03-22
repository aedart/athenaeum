<?php


namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidCookieFormatException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Http\Clients\Exceptions\InvalidCookieFormat;
use Aedart\Http\Cookies\SetCookie;

/**
 * Concerns Cookies
 *
 * @see Builder
 * @see Builder::withCookie
 * @see Builder::withCookies
 * @see Builder::withoutCookie
 * @see Builder::hasCookie
 * @see Builder::getCookie
 * @see Builder::getCookies
 * @see Builder::addCookie
 * @see Builder::makeCookie
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Cookies
{
    /**
     * Cookies
     *
     * @var Cookie[] Key = cookie name, value = cookie instance
     */
    protected array $cookies = [];

    /**
     * Add a cookie for the next request
     *
     * If a Cookie with the same name has already been added,
     * it will be overwritten.
     *
     * @param Cookie|array|callable $cookie If a callback is provided, a new {@see Cookie}
     *                          instance will be given as the callback's argument.
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function withCookie($cookie): Builder
    {
        if (is_array($cookie)) {
            $cookie = $this->makeCookie($cookie);
        }

        if (is_callable($cookie)) {
            $cookie = $this->resolveCallbackCookie($cookie);
        }

        if (!($cookie instanceof Cookie)) {
            throw new InvalidCookieFormat('Argument must be a Cookie instance, array, or callback');
        }

        // Add to list of cookies
        $this->cookies[$cookie->getName()] = $cookie;

        return $this;
    }

    /**
     * Add one or more cookies to the next request
     *
     * @see withCookie
     *
     * @param Cookie[]|callable[] $cookies List of cookies, callbacks or data-arrays
     *                              Callbacks are given new {@see Cookie} instance as argument.
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function withCookies(array $cookies = []): Builder
    {
        foreach ($cookies as $cookie) {
            $this->withCookie($cookie);
        }

        return $this;
    }

    /**
     * Remove the Cookie that matches given name,
     * for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutCookie(string $name): Builder
    {
        unset($this->cookies[$name]);

        return $this;
    }

    /**
     * Determine if a Cookie has been set, with the
     * given name
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasCookie(string $name): bool
    {
        return isset($this->cookies[$name]);
    }

    /**
     * Get the Cookie with the given name
     *
     * @param string $name
     *
     * @return Cookie|null
     */
    public function getCookie(string $name): ?Cookie
    {
        if ($this->hasCookie($name)) {
            return $this->cookies[$name];
        }

        return null;
    }

    /**
     * Get the cookies for the next request
     *
     * @return Cookie[]
     */
    public function getCookies(): array
    {
        return array_values($this->cookies);
    }

    /**
     * Add a cookie for the next request
     *
     * @see withCookie
     *
     * @param string $name
     * @param string|null $value [optional]
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function addCookie(string $name, ?string $value = null): Builder
    {
        return $this->withCookie([ 'name' => $name, 'value' => $value ]);
    }

    /**
     * Creates a new cookie instance.
     *
     * Method does NOT add the cookie into builder's list of
     * cookies.
     *
     * @param array $data [optional]
     *
     * @return Cookie
     */
    public function makeCookie(array $data = []): Cookie
    {
        // NOTE: The SetCookie inherits from Cookie. While this
        // shouldn't be used for requests, it might be useful
        // for responses, should such be required, e.g.
        // response formatting, ...etc.
        return new SetCookie($data);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves a cookie from given callback
     *
     * @param callable $callback New {@see Cookie} instance is given as callback argument
     *
     * @return Cookie
     */
    protected function resolveCallbackCookie(callable $callback): Cookie
    {
        // Create cookie
        $cookie = $this->makeCookie();

        // Invoke the callback
        $callback($cookie);

        // Finally, return cookie
        return $cookie;
    }
}
