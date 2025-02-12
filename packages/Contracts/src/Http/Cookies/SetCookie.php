<?php

namespace Aedart\Contracts\Http\Cookies;

/**
 * Http Set-Cookie
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Cookies
 */
interface SetCookie extends Cookie
{
    /**
     * Strict same-site policy
     *
     * "[...] The browser will only send cookies for same-site requests [...].
     * If the request originated from a different URL than the URL of the current
     * location, none of the cookies tagged with the Strict attribute will be
     * included. [...]" (mozilla.org)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#SameSite_cookies
     */
    public const string SAME_SITE_STRICT = 'strict';

    /**
     * Lax same-site policy
     *
     * "[...] Same-site cookies are withheld on cross-site subrequests, such as calls
     * to load images or frames, but will be sent when a user navigates to the URL
     * from an external site [...]" (mozilla.org)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#SameSite_cookies
     */
    public const string SAME_SITE_LAX = 'lax';

    /**
     * None same-site policy
     *
     * "[...] The browser will send cookies with both cross-site requests and same-site requests. [...]" (mozilla.org)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#SameSite_cookies
     */
    public const string SAME_SITE_NONE = 'none';

    /**
     * Set the maximum lifetime of the cookie
     *
     * If both expires and {@see maxAge} are set, then {@see maxAge} is favoured.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Session_cookies
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Date
     * @see https://tools.ietf.org/html/rfc7231#section-7.1.1.2
     *
     * @param string|int|null $expiresAt [optional] RFC7231 Formatted string date or timestamp
     *
     * @return self
     */
    public function expires(string|int|null $expiresAt = null): static;

    /**
     * Returns the maximum lifetime of the cookie
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Session_cookies
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Date
     * @see https://tools.ietf.org/html/rfc7231#section-7.1.1.2
     *
     * @return string|null RFC7231 Formatted string date
     */
    public function getExpires(): string|null;

    /**
     * Set the number of seconds until the cookie expires.
     *
     * Zero or negative values will result in immediate expiration
     * of the cookie.
     *
     * If both {@see expires} and max-age are set, then max-age is favoured.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Session_cookies
     *
     * @param int|null $seconds [optional]
     *
     * @return self
     */
    public function maxAge(int|null $seconds = null): static;

    /**
     * Returns the number of seconds until the cookie expires
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Session_cookies
     *
     * @return int|null
     */
    public function getMaxAge(): int|null;

    /**
     * Set the host(s) where the cookie will be sent to
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Scope_of_cookies
     *
     * @param string|null $domain [optional]
     *
     * @return self
     */
    public function domain(string|null $domain = null): static;

    /**
     * Returns the host(s) where the cookie will be sent to
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Scope_of_cookies
     *
     * @return string|null
     */
    public function getDomain(): string|null;

    /**
     * Set the cookie path that must exist on the requested url
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Scope_of_cookies
     *
     * @param string|null $path [optional]
     *
     * @return self
     */
    public function path(string|null $path = null): static;

    /**
     * Returns the cookie path that must exist on the requested url
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Scope_of_cookies
     *
     * @return string|null
     */
    public function getPath(): string|null;

    /**
     * Set the state of whether the cookie should be sent via https
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Secure_and_HttpOnly_cookies
     *
     * @param bool $isSecure [optional] True if cookie should only be sent via https
     *
     * @return self
     */
    public function secure(bool $isSecure = false): static;

    /**
     * Returns the cookie-secure state
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Secure_and_HttpOnly_cookies
     *
     * @return bool True if cookie should only be sent via https
     */
    public function getSecure(): bool;

    /**
     * Determine if cookie should only be sent via https
     *
     * Method is an alias for {@see getSecure}
     *
     * @return bool
     */
    public function isSecure(): bool;

    /**
     * Set the http only state
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Secure_and_HttpOnly_cookies
     *
     * @param bool $httpOnly [optional] If true, accessing the cookie is forbidden
     *                      via JavaScript.
     *
     * @return self
     */
    public function httpOnly(bool $httpOnly = false): static;

    /**
     * Get the http only state
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Secure_and_HttpOnly_cookies
     *
     * @return bool If true, accessing the cookie is forbidden via JavaScript.
     */
    public function getHttpOnly(): bool;

    /**
     * Determine if JavaScript is forbidden to access the
     * cookie.
     *
     * Method is an alias for {@see getHttpOnly}
     *
     * @return bool True if forbidden
     */
    public function isHttpOnly(): bool;

    /**
     * Set the same-site policy; whether cookie should be available for cross-site requests
     *
     * @see SAME_SITE_STRICT
     * @see SAME_SITE_LAX
     * @see SAME_SITE_NONE
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#SameSite_cookies
     *
     * @param string|null $policy [optional]
     *
     * @return self
     */
    public function sameSite(string|null $policy = null): static;

    /**
     * Get the same-site policy; whether cookie should be available for cross-site requests
     *
     * @see SAME_SITE_STRICT
     * @see SAME_SITE_LAX
     * @see SAME_SITE_NONE
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#SameSite_cookies
     *
     * @return string|null
     */
    public function getSameSite(): string|null;
}
