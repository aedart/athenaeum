<?php

namespace Aedart\Contracts\MimeTypes;

use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
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
     * Returns the detected mime-type
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
     */
    public function type(): string|null;

    /**
     * Returns the detected mime encoding
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
     */
    public function encoding(): string|null;

    /**
     * Returns the mime-type and encoding as defined by RFC 2045
     *
     * @see https://datatracker.ietf.org/doc/html/rfc2045
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
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
     *
     * @throws MimeTypeDetectionException
     */
    public function knownFileExtensions(): array;

    /**
     * Returns the underlying sampler this mime-type uses
     *
     * @return Sampler
     */
    public function sampler(): Sampler;
}
