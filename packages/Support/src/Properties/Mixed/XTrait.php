<?php

namespace Aedart\Support\Properties\Mixed;

/**
 * @deprecated Since v4.0, please use \Aedart\Support\Properties\Mixes\XTrait instead
 *
 * X Trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixed
 */
trait XTrait
{
    /**
     * Co-ordinate or value
     *
     * @var mixed|null
     */
    protected $x = null;

    /**
     * Set x
     *
     * @param mixed|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setX($value)
    {
        $this->x = $value;

        return $this;
    }

    /**
     * Get x
     *
     * If no "x" value set, method
     * sets and returns a default "x".
     *
     * @see getDefaultX()
     *
     * @return mixed|null x or null if no x has been set
     */
    public function getX()
    {
        if (!$this->hasX()) {
            $this->setX($this->getDefaultX());
        }
        return $this->x;
    }

    /**
     * Check if "x" has been set
     *
     * @return bool True if "x" has been set, false if not
     */
    public function hasX(): bool
    {
        return isset($this->x);
    }

    /**
     * Get a default "x" value, if any is available
     *
     * @return mixed|null Default "x" value or null if no default value is available
     */
    public function getDefaultX()
    {
        return null;
    }
}
