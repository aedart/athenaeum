<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Formatted name Aware
 *
 * Component is aware of string "formatted name"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface FormattedNameAware
{
    /**
     * Set formatted name
     *
     * @param string|null $name Formatted name of someone or something
     *
     * @return self
     */
    public function setFormattedName(string|null $name): static;

    /**
     * Get formatted name
     *
     * If no formatted name value set, method
     * sets and returns a default formatted name.
     *
     * @see getDefaultFormattedName()
     *
     * @return string|null formatted name or null if no formatted name has been set
     */
    public function getFormattedName(): string|null;

    /**
     * Check if formatted name has been set
     *
     * @return bool True if formatted name has been set, false if not
     */
    public function hasFormattedName(): bool;

    /**
     * Get a default formatted name value, if any is available
     *
     * @return string|null Default formatted name value or null if no default value is available
     */
    public function getDefaultFormattedName(): string|null;
}
