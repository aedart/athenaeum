<?php

namespace Aedart\Contracts\Utils\Dates;

use DateTimeInterface;

/**
 * Date Time Formats
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Dates
 */
interface DateTimeFormats
{
    /*****************************************************************
     * PHP's predefined formats
     ****************************************************************/

    /**
     * Atom (example: 2005-08-15T15:52:01+00:00)
     *
     * @see https://en.wikipedia.org/wiki/Atom_(web_standard)
     */
    public const ATOM = DateTimeInterface::ATOM;

    /**
     * HTTP Cookies (example: Monday, 15-Aug-2005 15:52:01 UTC)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#attributes
     */
    public const COOKIE = DateTimeInterface::COOKIE;

    /**
     * @deprecated Since PHP version 7.2
     *
     * @see \DateTimeInterface::ISO8601
     */
    public const ISO8601 = DateTimeInterface::ISO8601;

    /**
     * ISO-8601 Expanded (example: +10191-07-26T08:59:52+01:00)
     *
     * @see https://en.wikipedia.org/wiki/ISO_8601
     *
     * TODO: Enable this from PHP v8.2
     */
    //    public const ISO8601_EXPANDED = DateTimeInterface::ISO8601_EXPANDED;

    /**
     * RFC 822 (example: Mon, 15 Aug 05 15:52:01 +0000)
     *
     * @see https://www.w3.org/Protocols/rfc822/#z28
     */
    public const RFC822 = DateTimeInterface::RFC822;

    /**
     * RFC 850 (example: Monday, 15-Aug-05 15:52:01 UTC)
     *
     * @see https://www.rfc-editor.org/rfc/rfc850#section-2.1.4
     */
    public const RFC850 = DateTimeInterface::RFC850;

    /**
     * RFC 1036 (example: Mon, 15 Aug 05 15:52:01 +0000)
     *
     * @see https://www.rfc-editor.org/rfc/rfc1036#section-2.1.2
     */
    public const RFC1036 = DateTimeInterface::RFC1036;

    /**
     * RFC 1123 (example: Mon, 15 Aug 2005 15:52:01 +0000)
     *
     * @see https://www.rfc-editor.org/rfc/rfc1123#page-55
     */
    public const RFC1123 = DateTimeInterface::RFC1123;

    /**
     * RFC 2822 (example: Mon, 15 Aug 2005 15:52:01 +0000)
     *
     * @see https://www.rfc-editor.org/rfc/rfc2822#section-3.3
     */
    public const RFC2822 = DateTimeInterface::RFC2822;

    /**
     * RFC 3339 (example: 2005-08-15T15:52:01+00:00)
     *
     * @see RFC3339_ZULU
     * @see https://www.rfc-editor.org/rfc/rfc3339#section-5.6
     */
    public const RFC3339 = DateTimeInterface::RFC3339;

    /**
     * RFC 3339 EXTENDED format (example: 2005-08-15T15:52:01.000+00:00)
     *
     * @see RFC3339_EXTENDED_ZULU
     * @see https://www.rfc-editor.org/rfc/rfc3339#section-5.6
     */
    public const RFC3339_EXTENDED = DateTimeInterface::RFC3339_EXTENDED;

    /**
     * RFC 7231 (example: Sat, 30 Apr 2016 17:52:13 GMT)
     *
     * @see RFC9110
     * @see https://www.rfc-editor.org/rfc/rfc7231#section-7.1.1.1
     */
    public const RFC7231 = DateTimeInterface::RFC7231;

    /**
     * RSS (example: Mon, 15 Aug 2005 15:52:01 +0000)
     *
     * @see https://www.rssboard.org/rss-draft-1#data-types-datetime
     */
    public const RSS = DateTimeInterface::RSS;

    /**
     * World Wide Web Consortium (example: 2005-08-15T15:52:01+00:00)
     *
     * @see https://www.w3.org/TR/NOTE-datetime
     */
    public const W3C = DateTimeInterface::W3C;

    /*****************************************************************
     * Additional formats
     ****************************************************************/

    /**
     * RFC 3339 with support for "Z" (zulu) (example: 2005-08-15T15:52:01Z, or 2005-08-15T15:52:01+00:00)
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339#section-5.6
     */
    public const RFC3339_ZULU = 'Y-m-d\TH:i:sp';

    /**
     * RFC 3339 EXTENDED format, with support for "Z" (zulu) (example: 2005-08-15T15:52:01.000Z, or 2005-08-15T15:52:01.000+00:00)
     *
     * @see https://www.rfc-editor.org/rfc/rfc3339#section-5.6
     */
    public const RFC3339_EXTENDED_ZULU = 'Y-m-d\TH:i:s.vp';

    /**
     * RFC 9110 "IMF-fixdate" format (example: Sun, 06 Nov 1994 08:49:37 GMT)
     *
     * Also known as "Http Date"
     *
     * **Note**: _Format does NOT support leap seconds! E.g. 23:59:60 is not accepted by this PHP format!_
     *
     * @see https://httpwg.org/specs/rfc9110.html#http.date
     * @see https://www.rfc-editor.org/rfc/rfc7231#section-7.1.1.1
     */
    public const RFC9110 = self::RFC7231;
}
