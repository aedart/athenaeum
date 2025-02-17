<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Z Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\ZAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait ZTrait
{
    /**
     * Co-ordinate or value
     *
     * @var float|null
     */
    protected float|null $z = null;

    /**
     * Set z
     *
     * @param float|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setZ(float|null $value): static
    {
        $this->z = $value;

        return $this;
    }

    /**
     * Get z
     *
     * If no z value set, method
     * sets and returns a default z.
     *
     * @see getDefaultZ()
     *
     * @return float|null z or null if no z has been set
     */
    public function getZ(): float|null
    {
        if (!$this->hasZ()) {
            $this->setZ($this->getDefaultZ());
        }
        return $this->z;
    }

    /**
     * Check if z has been set
     *
     * @return bool True if z has been set, false if not
     */
    public function hasZ(): bool
    {
        return isset($this->z);
    }

    /**
     * Get a default z value, if any is available
     *
     * @return float|null Default z value or null if no default value is available
     */
    public function getDefaultZ(): float|null
    {
        return null;
    }
}
