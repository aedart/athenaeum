<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Z Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\ZAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait ZTrait
{
    /**
     * Co-ordinate or value
     *
     * @var mixed
     */
    protected $z = null;

    /**
     * Set z
     *
     * @param mixed $value Co-ordinate or value
     *
     * @return self
     */
    public function setZ(mixed $value): static
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
     * @return mixed z or null if no z has been set
     */
    public function getZ(): mixed
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
     * @return mixed Default z value or null if no default value is available
     */
    public function getDefaultZ(): mixed
    {
        return null;
    }
}
