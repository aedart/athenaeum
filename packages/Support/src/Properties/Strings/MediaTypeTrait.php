<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Media type Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\MediaTypeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait MediaTypeTrait
{
    /**
     * Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name
     *
     * @var string|null
     */
    protected string|null $mediaType = null;

    /**
     * Set media type
     *
     * @param string|null $type Media Type (also known as MIME Type), acc. to IANA standard, or perhaps a type name
     *
     * @return self
     */
    public function setMediaType(string|null $type): static
    {
        $this->mediaType = $type;

        return $this;
    }

    /**
     * Get media type
     *
     * If no media type value set, method
     * sets and returns a default media type.
     *
     * @see getDefaultMediaType()
     *
     * @return string|null media type or null if no media type has been set
     */
    public function getMediaType(): string|null
    {
        if (!$this->hasMediaType()) {
            $this->setMediaType($this->getDefaultMediaType());
        }
        return $this->mediaType;
    }

    /**
     * Check if media type has been set
     *
     * @return bool True if media type has been set, false if not
     */
    public function hasMediaType(): bool
    {
        return isset($this->mediaType);
    }

    /**
     * Get a default media type value, if any is available
     *
     * @return string|null Default media type value or null if no default value is available
     */
    public function getDefaultMediaType(): string|null
    {
        return null;
    }
}
