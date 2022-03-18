<?php

namespace Aedart\Contracts\MimeTypes;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * Mime-Type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes
 */
interface MimeType extends
    Arrayable,
    Stringable
{
    /**
     * Returns a short description of the mime-type
     *
     * @return string|null
     */
    public function description(): string|null;

    /**
     * Returns the detected mime-type
     *
     * @return string|null
     */
    public function type(): string|null;

    /**
     * Returns the detected mime encoding
     *
     * @return string|null
     */
    public function encoding(): string|null;

    /**
     * Returns the mime-type and encoding as defined by RFC 2045
     *
     * @see https://datatracker.ietf.org/doc/html/rfc2045
     *
     * @return string|null
     */
    public function mime(): string|null;

    /**
     * Returns list of known file-extensions that matches detected
     * mime-type.
     *
     * **Note** _Some mime-types that are known to have multiple
     * extensions, e.g. JPEG images: jpeg, jpg, jpe, jfif, ...etc_
     *
     * @return string[]
     */
    public function knownFileExtensions(): array;
}
