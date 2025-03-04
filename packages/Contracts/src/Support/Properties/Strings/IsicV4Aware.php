<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Isic v4 Aware
 *
 * Component is aware of string "isic v4"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IsicV4Aware
{
    /**
     * Set isic v4
     *
     * @param string|null $code International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code
     *
     * @return self
     */
    public function setIsicV4(string|null $code): static;

    /**
     * Get isic v4
     *
     * If no isic v4 value set, method
     * sets and returns a default isic v4.
     *
     * @see getDefaultIsicV4()
     *
     * @return string|null isic v4 or null if no isic v4 has been set
     */
    public function getIsicV4(): string|null;

    /**
     * Check if isic v4 has been set
     *
     * @return bool True if isic v4 has been set, false if not
     */
    public function hasIsicV4(): bool;

    /**
     * Get a default isic v4 value, if any is available
     *
     * @return string|null Default isic v4 value or null if no default value is available
     */
    public function getDefaultIsicV4(): string|null;
}
