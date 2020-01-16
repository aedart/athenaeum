<?php

namespace Aedart\Support\Properties\Booleans;

/**
 * On Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Booleans\OnAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Booleans
 */
trait OnTrait
{
    /**
     * 
     *
     * @var bool|null
     */
    protected ?bool $on = null;

    /**
     * Set on
     *
     * @param bool|null $isOn 
     *
     * @return self
     */
    public function setOn(?bool $isOn)
    {
        $this->on = $isOn;

        return $this;
    }

    /**
     * Get on
     *
     * If no "on" value set, method
     * sets and returns a default "on".
     *
     * @see getDefaultOn()
     *
     * @return bool|null on or null if no on has been set
     */
    public function getOn() : ?bool
    {
        if ( ! $this->hasOn()) {
            $this->setOn($this->getDefaultOn());
        }
        return $this->on;
    }

    /**
     * Check if "on" has been set
     *
     * @return bool True if "on" has been set, false if not
     */
    public function hasOn() : bool
    {
        return isset($this->on);
    }

    /**
     * Get a default "on" value, if any is available
     *
     * @return bool|null Default "on" value or null if no default value is available
     */
    public function getDefaultOn() : ?bool
    {
        return null;
    }
}
