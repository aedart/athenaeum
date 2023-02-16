<?php

namespace Aedart\Contracts\ETags;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;

/**
 * ETag Generator
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface Generator
{
    /**
     * Generate an ETag for given content
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.etag
     *
     * @param  mixed  $content
     * @param  bool  $weak  [optional] When true, ETag is flagged as "weak",
     *                      indented to be used for "weak comparison" (E.g. If-None-Match Http header comparison).
     *                      When false, ETag is not flagged as "weak",
     *                      intended to be used for "strong comparison" (E.g. If-Match Http header comparison).
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for given content
     */
    public function make(mixed $content, bool $weak = true): ETag;

    /**
     * Generate an ETag for given content, intended for "weak comparison"
     * (E.g. If-None-Match Http header comparison).
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-none-match
     *
     * @param  mixed  $content
     *
     * @return ETag Flagged as "weak"
     *
     * @throws ETagGeneratorException If unable to generate ETag for given content
     */
    public function makeWeak(mixed $content): ETag;

    /**
     * Generate an ETag for given content, intended for "strong comparison"
     * (E.g. If-Match Http header comparison)
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-match
     *
     * @param  mixed  $content
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for given content
     */
    public function makeStrong(mixed $content): ETag;
}
