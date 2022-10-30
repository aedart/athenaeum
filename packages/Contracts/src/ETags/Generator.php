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
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for given content
     */
    public function make(mixed $content): ETag;
}