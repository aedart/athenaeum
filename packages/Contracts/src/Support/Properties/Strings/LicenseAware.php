<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * License Aware
 *
 * Component is aware of string "license"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LicenseAware
{
    /**
     * Set license
     *
     * @param string|null $identifier License name or identifier
     *
     * @return self
     */
    public function setLicense(string|null $identifier): static;

    /**
     * Get license
     *
     * If no license value set, method
     * sets and returns a default license.
     *
     * @see getDefaultLicense()
     *
     * @return string|null license or null if no license has been set
     */
    public function getLicense(): string|null;

    /**
     * Check if license has been set
     *
     * @return bool True if license has been set, false if not
     */
    public function hasLicense(): bool;

    /**
     * Get a default license value, if any is available
     *
     * @return string|null Default license value or null if no default value is available
     */
    public function getDefaultLicense(): string|null;
}
