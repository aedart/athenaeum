<?php

namespace Aedart\Support\Properties\Booleans;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
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
     * Is on
     *
     * @var bool|null
     */
    protected bool|null $on = null;

    /**
     * Set on
     *
     * @param bool|null $isOn Is on
     *
     * @return self
     */
    public function setOn(bool|null $isOn): static
    {
        $this->on = $isOn;

        return $this;
    }

    /**
     * Get on
     *
     * If no on value set, method
     * sets and returns a default on.
     *
     * @see getDefaultOn()
     *
     * @return bool|null on or null if no on has been set
     */
    public function getOn(): bool|null
    {
        if (!$this->hasOn()) {
            $this->setOn($this->getDefaultOn());
        }
        return $this->on;
    }

    /**
     * Check if on has been set
     *
     * @return bool True if on has been set, false if not
     */
    public function hasOn(): bool
    {
        return isset($this->on);
    }

    /**
     * Get a default on value, if any is available
     *
     * @return bool|null Default on value or null if no default value is available
     */
    public function getDefaultOn(): bool|null
    {
        return null;
    }
}
