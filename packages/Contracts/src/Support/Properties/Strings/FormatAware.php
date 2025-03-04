<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Format Aware
 *
 * Component is aware of string "format"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface FormatAware
{
    /**
     * Set format
     *
     * @param string|null $format The shape, size and presentation or medium of an item or component
     *
     * @return self
     */
    public function setFormat(string|null $format): static;

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
    public function getFormat(): string|null;

    /**
     * Check if format has been set
     *
     * @return bool True if format has been set, false if not
     */
    public function hasFormat(): bool;

    /**
     * Get a default format value, if any is available
     *
     * @return string|null Default format value or null if no default value is available
     */
    public function getDefaultFormat(): string|null;
}
