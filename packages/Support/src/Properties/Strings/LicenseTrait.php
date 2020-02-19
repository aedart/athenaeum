<?php

namespace Aedart\Support\Properties\Strings;

/**
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
    protected ?string $license = null;

    /**
     * Set license
     *
     * @param string|null $identifier License name or identifier
     *
     * @return self
     */
    public function setLicense(?string $identifier)
    {
        $this->license = $identifier;

        return $this;
    }

    /**
     * Get license
     *
     * If no "license" value set, method
     * sets and returns a default "license".
     *
     * @see getDefaultLicense()
     *
     * @return string|null license or null if no license has been set
     */
    public function getLicense(): ?string
    {
        if (!$this->hasLicense()) {
            $this->setLicense($this->getDefaultLicense());
        }
        return $this->license;
    }

    /**
     * Check if "license" has been set
     *
     * @return bool True if "license" has been set, false if not
     */
    public function hasLicense(): bool
    {
        return isset($this->license);
    }

    /**
     * Get a default "license" value, if any is available
     *
     * @return string|null Default "license" value or null if no default value is available
     */
    public function getDefaultLicense(): ?string
    {
        return null;
    }
}
