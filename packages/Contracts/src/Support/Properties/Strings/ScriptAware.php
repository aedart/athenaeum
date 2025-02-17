<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Script Aware
 *
 * Component is aware of string "script"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ScriptAware
{
    /**
     * Set script
     *
     * @param string|null $script Script of some kind or path to some script
     *
     * @return self
     */
    public function setScript(string|null $script): static;

    /**
     * Get script
     *
     * If no script value set, method
     * sets and returns a default script.
     *
     * @see getDefaultScript()
     *
     * @return string|null script or null if no script has been set
     */
    public function getScript(): string|null;

    /**
     * Check if script has been set
     *
     * @return bool True if script has been set, false if not
     */
    public function hasScript(): bool;

    /**
     * Get a default script value, if any is available
     *
     * @return string|null Default script value or null if no default value is available
     */
    public function getDefaultScript(): string|null;
}
