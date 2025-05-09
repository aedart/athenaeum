<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Alias Aware
 *
 * Component is aware of string "alias"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AliasAware
{
    /**
     * Set alias
     *
     * @param string|null $name An alternate name of an item or component
     *
     * @return self
     */
    public function setAlias(string|null $name): static;

    /**
     * Get alias
     *
     * If no alias value set, method
     * sets and returns a default alias.
     *
     * @see getDefaultAlias()
     *
     * @return string|null alias or null if no alias has been set
     */
    public function getAlias(): string|null;

    /**
     * Check if alias has been set
     *
     * @return bool True if alias has been set, false if not
     */
    public function hasAlias(): bool;

    /**
     * Get a default alias value, if any is available
     *
     * @return string|null Default alias value or null if no default value is available
     */
    public function getDefaultAlias(): string|null;
}
