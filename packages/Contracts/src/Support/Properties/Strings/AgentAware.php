<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Agent Aware
 *
 * Component is aware of string "agent"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AgentAware
{
    /**
     * Set agent
     *
     * @param string|null $agent Someone or something that acts on behalf of someone else or something else
     *
     * @return self
     */
    public function setAgent(?string $agent);

    /**
     * Get agent
     *
     * If no "agent" value set, method
     * sets and returns a default "agent".
     *
     * @see getDefaultAgent()
     *
     * @return string|null agent or null if no agent has been set
     */
    public function getAgent() : ?string;

    /**
     * Check if "agent" has been set
     *
     * @return bool True if "agent" has been set, false if not
     */
    public function hasAgent() : bool;

    /**
     * Get a default "agent" value, if any is available
     *
     * @return string|null Default "agent" value or null if no default value is available
     */
    public function getDefaultAgent() : ?string;
}
