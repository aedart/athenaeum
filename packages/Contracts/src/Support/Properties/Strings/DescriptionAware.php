<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Description Aware
 *
 * Component is aware of string "description"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DescriptionAware
{
    /**
     * Set description
     *
     * @param string|null $description Description
     *
     * @return self
     */
    public function setDescription(string|null $description): static;

    /**
     * Get description
     *
     * If no description value set, method
     * sets and returns a default description.
     *
     * @see getDefaultDescription()
     *
     * @return string|null description or null if no description has been set
     */
    public function getDescription(): string|null;

    /**
     * Check if description has been set
     *
     * @return bool True if description has been set, false if not
     */
    public function hasDescription(): bool;

    /**
     * Get a default description value, if any is available
     *
     * @return string|null Default description value or null if no default value is available
     */
    public function getDefaultDescription(): string|null;
}
