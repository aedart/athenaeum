<?php


namespace Aedart\Http\Clients\Requests\Builders\Concerns;

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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function withCookies(array $cookies = []): Builder
    {
        foreach ($cookies as $cookie) {
            $this->withCookie($cookie);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withoutCookie(string $name): Builder
    {
        unset($this->cookies[$name]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasCookie(string $name): bool
    {
        return isset($this->cookies[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getCookie(string $name): ?Cookie
    {
        if ($this->hasCookie($name)) {
            return $this->cookies[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getCookies(): array
    {
        return array_values($this->cookies);
    }

    /**
     * @inheritdoc
     */
    public function addCookie(string $name, ?string $value = null): Builder
    {
        return $this->withCookie([ 'name' => $name, 'value' => $value ]);
    }

    /**
     * @inheritdoc
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
