<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Zone Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\ZoneAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait ZoneTrait
{
    /**
     * Name or identifier of area, district or division
     *
     * @var int|null
     */
    protected int|null $zone = null;

    /**
     * Set zone
     *
     * @param int|null $identifier Name or identifier of area, district or division
     *
     * @return self
     */
    public function setZone(int|null $identifier): static
    {
        $this->zone = $identifier;

        return $this;
    }

    /**
     * Get zone
     *
     * If no zone value set, method
     * sets and returns a default zone.
     *
     * @see getDefaultZone()
     *
     * @return int|null zone or null if no zone has been set
     */
    public function getZone(): int|null
    {
        if (!$this->hasZone()) {
            $this->setZone($this->getDefaultZone());
        }
        return $this->zone;
    }

    /**
     * Check if zone has been set
     *
     * @return bool True if zone has been set, false if not
     */
    public function hasZone(): bool
    {
        return isset($this->zone);
    }

    /**
     * Get a default zone value, if any is available
     *
     * @return int|null Default zone value or null if no default value is available
     */
    public function getDefaultZone(): int|null
    {
        return null;
    }
}
