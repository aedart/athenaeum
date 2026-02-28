<?php

namespace Aedart\Contracts\Http\Cookies;

use ValueError;

/**
 * Http Set-Cookie Same-Site Attribute
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Guides/Cookies#controlling_third-party_cookies_with_samesite
 * @ßee https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#samesitesamesite-value
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Cookies
 */
enum SameSite: string
{
    /**
     * "[...] The browser will only send cookies for same-site requests [...].
     * If the request originated from a different URL than the URL of the current
     * location, none of the cookies tagged with the Strict attribute will be
     * included. [...]" (mozilla.org)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#strict
     */
    case STRICT = 'Strict';

    /**
     * "[...] Same-site cookies are withheld on cross-site subrequests, such as calls
     * to load images or frames, but will be sent when a user navigates to the URL
     * from an external site [...]" (mozilla.org)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#lax
     */
    case LAX = 'Lax';

    /**
     * "[...] The browser will send cookies with both cross-site requests and same-site requests. [...]
     * The `Secure` attribute must also be set when using this value [...]" (mozilla.org)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#none
     */
    case NONE = 'None';

    /**
     * Returns all cases' values
     *
     * @return string[]
     */
    static public function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    /**
     * Translates a string (case-insensitive) into the corresponding `SameSite` case, if any.
     *
     * @param  string  $value
     *
     * @return SameSite
     *
     * @throws ValueError if there is no matching case defined
     *
     * @see static::from()
     */
    static public function fromValue(string $value): SameSite
    {
        return self::from(ucfirst(strtolower($value)));
    }

    /**
     * Translates a string (case-insensitive) into the corresponding `SameSite` case, if any.
     * If there is no matching case defined, it will return null.
     *
     * @param  string  $value
     *
     * @return SameSite|null
     *
     * @see static::tryFrom()
     */
    static public function tryFromValue(string $value): SameSite|null
    {
        return self::tryFrom(ucfirst(strtolower($value)));
    }
}
