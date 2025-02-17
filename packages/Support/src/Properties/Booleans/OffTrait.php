<?php

namespace Aedart\Support\Properties\Booleans;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Off Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Booleans\OffAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Booleans
 */
trait OffTrait
{
    /**
     * Is off
     *
     * @var bool|null
     */
    protected bool|null $off = null;

    /**
     * Set off
     *
     * @param bool|null $isOff Is off
     *
     * @return self
     */
    public function setOff(bool|null $isOff): static
    {
        $this->off = $isOff;

        return $this;
    }

    /**
     * Get off
     *
     * If no off value set, method
     * sets and returns a default off.
     *
     * @see getDefaultOff()
     *
     * @return bool|null off or null if no off has been set
     */
    public function getOff(): bool|null
    {
        if (!$this->hasOff()) {
            $this->setOff($this->getDefaultOff());
        }
        return $this->off;
    }

    /**
     * Check if off has been set
     *
     * @return bool True if off has been set, false if not
     */
    public function hasOff(): bool
    {
        return isset($this->off);
    }

    /**
     * Get a default off value, if any is available
     *
     * @return bool|null Default off value or null if no default value is available
     */
    public function getDefaultOff(): bool|null
    {
        return null;
    }
}
