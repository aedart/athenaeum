<?php

namespace Aedart\Contracts\ETags;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use Stringable;

/**
 * ETag
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface ETag extends Stringable
{
    /**
     * Weak ETag indicator / prefix
     */
    public const string WEAK_INDICATOR = 'W/';

    /**
     * Wildcard symbol
     */
    public const string WILDCARD_SYMBOL = '*';

    /**
     * Creates a new ETag instance
     *
     * @param  string  $rawValue
     * @param  bool  $isWeak  [optional]
     *
     * @return static
     *
     * @throws ETagException If empty string provided as raw value
     */
    public static function make(string $rawValue, bool $isWeak = false): static;

    /**
     * Creates a collection of Etags from given raw http header value
     *
     * The "raw" Http header value can, for instance, be from an `If-Match` or
     * `If-None-Match` header.
     *
     * **WARNING:**: _A collection can consist of a list of etags or a single wildcard (*) etag._
     * _Mixing wildcard etag with "regular" etags will cause exception to be thrown!_
     * _See RFC-9110's notes regarding `If-Match` and `If-None-Match` header field for more information_
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-match
     * @see https://httpwg.org/specs/rfc9110.html#field.if-none-match
     *
     * @param  string  $rawHeaderValue E.g. W/"15487", W/"r2d23574", W/"c3pio784"
     *
     * @return Collection
     *
     * @throws ETagException If unable to parse given value
     */
    public static function parse(string $rawHeaderValue): Collection;

    /**
     * Creates a single new ETag instance from given value
     *
     * **Caution**: _Method is NOT able to parse multiple etags from given
     * header value! Use {@see parse()} instead._
     *
     * @param  string  $value E.g. "33a64df551425fcc55e4d42a148795d9f25f89d4", W/"0815", or * (wildcard)
     *
     * @return static
     *
     * @throws ETagException If unable to parse given value
     */
    public static function parseSingle(string $value): static;

    /**
     * Return the raw value of the ETag
     *
     * Raw value, in this context, means the ETag entity value without double quotes or
     * the "W/" (weak tag indicator)
     *
     * @return string E.g. 33a64df551425fcc55e4d42a148795d9f25f89d4
     */
    public function raw(): string;

    /**
     * Return ETag's value
     *
     * @return string E.g. "33a64df551425fcc55e4d42a148795d9f25f89d4" or W/"0815"
     */
    public function value(): string;

    /**
     * Returns string representation of this ETag
     *
     * Alias for {@see value}
     *
     * @return string
     */
    public function toString(): string;

    /**
     * Determine if ETag is flagged as "weak" (for weak comparison)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag#directives
     *
     * @return bool
     */
    public function isWeak(): bool;

    /**
     * Determine if ETag is NOT flagged as "weak" (for strong comparison)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag#directives
     *
     * @return bool
     */
    public function isStrong(): bool;

    /**
     * Determine if this ETag's value is set to '*' (wildcard / asterisk)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Match#directives
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-None-Match#directives
     *
     * @return bool
     */
    public function isWildcard(): bool;

    /**
     * Determine if this ETag's value matches given ETag's value
     *
     * By default, this method uses "weak comparison".
     *
     * **Note**: _If this ETag's or given ETag's value is '*' (wildcard / asterisk),
     * then method returns true, regardless of strong or weak
     * comparison mode._
     *
     * @see https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2
     *
     * @param  ETag|string  $eTag ETag instance or HTTP header value
     * @param  bool  $strongComparison  [optional] When true, two ETags are equivalent if
     *                                  both are NOT WEAK and their raw values match
     *                                  character-by-character.
     *                                  When false, two ETags are equivalent if their
     *                                  raw values match character-by-character, regardless
     *                                  of either or both being tagged as "weak"
     *
     * @return bool
     */
    public function matches(ETag|string $eTag, bool $strongComparison = false): bool;

    /**
     * Determine if this ETag's value does not match given ETag's value
     *
     * Opposite of the {@see matches} method.
     *
     * @param  ETag|string  $eTag ETag instance or HTTP header value
     * @param  bool  $strongComparison  [optional] When true, two ETags are equivalent if
     *                                  both are NOT WEAK and their raw values match
     *                                  character-by-character.
     *                                  When false, two ETags are equivalent if their
     *                                  raw values match character-by-character, regardless
     *                                  of either or both being tagged as "weak"
     *
     * @return bool
     */
    public function doesNotMatch(ETag|string $eTag, bool $strongComparison = false): bool;
}
