<?php

namespace Aedart\Support\Properties\Integers;

/**
 * License Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\LicenseAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait LicenseTrait
{
    /**
     * License name or identifier
     *
     * @var int|null
     */
    protected ?int $license = null;

    /**
     * Set license
     *
     * @param int|null $identifier License name or identifier
     *
     * @return self
     */
    public function setLicense(?int $identifier)
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
     * @return int|null license or null if no license has been set
     */
    public function getLicense(): ?int
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
     * @return int|null Default "license" value or null if no default value is available
     */
    public function getDefaultLicense(): ?int
    {
        return null;
    }
}
