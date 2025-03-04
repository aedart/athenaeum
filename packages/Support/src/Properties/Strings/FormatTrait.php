<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Format Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\FormatAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait FormatTrait
{
    /**
     * The shape, size and presentation or medium of an item or component
     *
     * @var string|null
     */
    protected string|null $format = null;

    /**
     * Set format
     *
     * @param string|null $format The shape, size and presentation or medium of an item or component
     *
     * @return self
     */
    public function setFormat(string|null $format): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * If no format value set, method
     * sets and returns a default format.
     *
     * @see getDefaultFormat()
     *
     * @return string|null format or null if no format has been set
     */
    public function getFormat(): string|null
    {
        if (!$this->hasFormat()) {
            $this->setFormat($this->getDefaultFormat());
        }
        return $this->format;
    }

    /**
     * Check if format has been set
     *
     * @return bool True if format has been set, false if not
     */
    public function hasFormat(): bool
    {
        return isset($this->format);
    }

    /**
     * Get a default format value, if any is available
     *
     * @return string|null Default format value or null if no default value is available
     */
    public function getDefaultFormat(): string|null
    {
        return null;
    }
}
