<?php

namespace Aedart\Support\Properties\Mixed;

/**
 * @deprecated Since v4.0, please use \Aedart\Support\Properties\Mixes\YTrait instead
 *
 * Y Trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixed
 */
trait YTrait
{
    /**
     * Co-ordinate or value
     *
     * @var mixed|null
     */
    protected $y = null;

    /**
     * Set y
     *
     * @param mixed|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setY($value)
    {
        $this->y = $value;

        return $this;
    }

    /**
     * Get y
     *
     * If no "y" value set, method
     * sets and returns a default "y".
     *
     * @see getDefaultY()
     *
     * @return mixed|null y or null if no y has been set
     */
    public function getY()
    {
        if (!$this->hasY()) {
            $this->setY($this->getDefaultY());
        }
        return $this->y;
    }

    /**
     * Check if "y" has been set
     *
     * @return bool True if "y" has been set, false if not
     */
    public function hasY(): bool
    {
        return isset($this->y);
    }

    /**
     * Get a default "y" value, if any is available
     *
     * @return mixed|null Default "y" value or null if no default value is available
     */
    public function getDefaultY()
    {
        return null;
    }
}
