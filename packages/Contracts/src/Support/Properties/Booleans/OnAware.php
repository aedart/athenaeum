<?php

namespace Aedart\Contracts\Support\Properties\Booleans;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * On Aware
 *
 * Component is aware of bool "on"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Booleans
 */
interface OnAware
{
    /**
     * Set on
     *
     * @param bool|null $isOn Is on
     *
     * @return self
     */
    public function setOn(bool|null $isOn): static;

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
    public function getOn(): bool|null;

    /**
     * Check if on has been set
     *
     * @return bool True if on has been set, false if not
     */
    public function hasOn(): bool;

    /**
     * Get a default on value, if any is available
     *
     * @return bool|null Default on value or null if no default value is available
     */
    public function getDefaultOn(): bool|null;
}
