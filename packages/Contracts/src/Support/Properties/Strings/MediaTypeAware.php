<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Media type Aware
 *
 * Component is aware of string "media type"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface MediaTypeAware
{
    /**
     * Set media type
     *
     * @param string|null $type Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name
     *
     * @return self
     */
    public function setMediaType(?string $type);

    /**
     * Get media type
     *
     * If no "media type" value set, method
     * sets and returns a default "media type".
     *
     * @see getDefaultMediaType()
     *
     * @return string|null media type or null if no media type has been set
     */
    public function getMediaType() : ?string;

    /**
     * Check if "media type" has been set
     *
     * @return bool True if "media type" has been set, false if not
     */
    public function hasMediaType() : bool;

    /**
     * Get a default "media type" value, if any is available
     *
     * @return string|null Default "media type" value or null if no default value is available
     */
    public function getDefaultMediaType() : ?string;
}
