<?php

namespace Aedart\Support\Properties\Mixed;

/**
 * Z Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixed\ZAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixed
 */
trait ZTrait
{
    /**
     * Co-ordinate or value
     *
     * @var mixed|null
     */
    protected $z = null;

    /**
     * Set z
     *
     * @param mixed|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setZ($value)
    {
        $this->z = $value;

        return $this;
    }

    /**
     * Get z
     *
     * If no "z" value set, method
     * sets and returns a default "z".
     *
     * @see getDefaultZ()
     *
     * @return mixed|null z or null if no z has been set
     */
    public function getZ()
    {
        if (!$this->hasZ()) {
            $this->setZ($this->getDefaultZ());
        }
        return $this->z;
    }

    /**
     * Check if "z" has been set
     *
     * @return bool True if "z" has been set, false if not
     */
    public function hasZ(): bool
    {
        return isset($this->z);
    }

    /**
     * Get a default "z" value, if any is available
     *
     * @return mixed|null Default "z" value or null if no default value is available
     */
    public function getDefaultZ()
    {
        return null;
    }
}
