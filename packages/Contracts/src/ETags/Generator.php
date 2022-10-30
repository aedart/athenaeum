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
     * @param  mixed  $content
     *
     * @return string
     *
     * @throws ETagGeneratorException If unable to generate ETag for given content
     */
    public function make(mixed $content): string;

    /**
     * Compare two ETags against each other
     *
     * @param  string  $knownETag ETag of known resource or content
     * @param  string  $userETag User provided ETag, e.g. from If-Match HTTP Header
     *
     * @return bool True if both ETags are equal
     */
    public function matches(string $knownETag, string $userETag): bool;
}