<?php

namespace Aedart\Contracts\MimeTypes;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * MIME-Type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes
 */
interface MimeType extends
    Arrayable,
    Stringable
{
    /**
     * Determines if this MIME-type instance is valid
     *
     * Method returns true if the {@see type()} returns
     * a string MIME-type. Otherwise, false is returned.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Returns a short description of the MIME-type
     *
     * @return string|null
     */
    public function description(): string|null;

    /**
     * Returns the detected MIME-type
     *
     * @return string|null
     */
    public function type(): string|null;

    /**
     * Returns the detected MIME encoding
     *
     * @return string|null
     */
    public function encoding(): string|null;

    /**
     * Returns the MIME-type and encoding as defined by RFC 2045
     *
     * @see https://datatracker.ietf.org/doc/html/rfc2045
     *
     * @return string|null
     */
    public function mime(): string|null;

    /**
     * Returns list of known file-extensions that matches detected
     * MIME-type.
     *
     * **Note** _Some mime-types that are known to have multiple
     * extensions, e.g. JPEG images: jpeg, jpg, jpe, jfif, ...etc_
     *
     * @return string[]
     */
    public function knownFileExtensions(): array;
}
