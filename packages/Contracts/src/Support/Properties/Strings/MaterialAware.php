<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Material Aware
 *
 * Component is aware of string "material"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface MaterialAware
{
    /**
     * Set material
     *
     * @param string|null $identifier Name or identifier of a material, e.g. leather, wool, cotton, paper.
     *
     * @return self
     */
    public function setMaterial(string|null $identifier): static;

    /**
     * Get material
     *
     * If no material value set, method
     * sets and returns a default material.
     *
     * @see getDefaultMaterial()
     *
     * @return string|null material or null if no material has been set
     */
    public function getMaterial(): string|null;

    /**
     * Check if material has been set
     *
     * @return bool True if material has been set, false if not
     */
    public function hasMaterial(): bool;

    /**
     * Get a default material value, if any is available
     *
     * @return string|null Default material value or null if no default value is available
     */
    public function getDefaultMaterial(): string|null;
}
