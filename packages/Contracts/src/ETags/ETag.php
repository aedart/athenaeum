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
     * Creates a new ETag instance from given HTTP header value
     *
     * @param  string  $value HTTP header value, e.g. "33a64df551425fcc55e4d42a148795d9f25f89d4" or W/"0815"
     *
     * @return static
     *
     * @throws ETagException If unable to parse given value
     */
    public static function parse(string $value): static;

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
     * Determine if ETag is weak
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag#directives
     *
     * @return bool
     */
    public function isWeak(): bool;

    /**
     * Determine if this ETag's raw value matches that of the given
     *
     * **Caution**: _Method matches the raw values of the ETags. It
     * completely ignores whether ETags are weak or not. E.g.:_
     * _W/"1234" and "1234" are equivalent_
     *
     * @param  ETag|string  $eTag ETag instance or HTTP header value
     *
     * @return bool
     */
    public function matches(ETag|string $eTag): bool;
}