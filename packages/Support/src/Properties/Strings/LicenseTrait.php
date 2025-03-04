<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * License Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LicenseAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LicenseTrait
{
    /**
     * License name or identifier
     *
     * @var string|null
     */
    protected string|null $license = null;

    /**
     * Set license
     *
     * @param string|null $identifier License name or identifier
     *
     * @return self
     */
    public function setLicense(string|null $identifier): static
    {
        $this->license = $identifier;

        return $this;
    }

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
    public function getLicense(): string|null
    {
        if (!$this->hasLicense()) {
            $this->setLicense($this->getDefaultLicense());
        }
        return $this->license;
    }

    /**
     * Check if license has been set
     *
     * @return bool True if license has been set, false if not
     */
    public function hasLicense(): bool
    {
        return isset($this->license);
    }

    /**
     * Get a default license value, if any is available
     *
     * @return string|null Default license value or null if no default value is available
     */
    public function getDefaultLicense(): string|null
    {
        return null;
    }
}
