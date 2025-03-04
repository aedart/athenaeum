<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Source Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\SourceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait SourceTrait
{
    /**
     * The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source
     *
     * @var string|null
     */
    protected string|null $source = null;

    /**
     * Set source
     *
     * @param string|null $source The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source
     *
     * @return self
     */
    public function setSource(string|null $source): static
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * If no source value set, method
     * sets and returns a default source.
     *
     * @see getDefaultSource()
     *
     * @return string|null source or null if no source has been set
     */
    public function getSource(): string|null
    {
        if (!$this->hasSource()) {
            $this->setSource($this->getDefaultSource());
        }
        return $this->source;
    }

    /**
     * Check if source has been set
     *
     * @return bool True if source has been set, false if not
     */
    public function hasSource(): bool
    {
        return isset($this->source);
    }

    /**
     * Get a default source value, if any is available
     *
     * @return string|null Default source value or null if no default value is available
     */
    public function getDefaultSource(): string|null
    {
        return null;
    }
}
