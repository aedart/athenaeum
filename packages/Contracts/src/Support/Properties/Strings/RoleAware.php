<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Role Aware
 *
 * Component is aware of string "role"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface RoleAware
{
    /**
     * Set role
     *
     * @param string|null $identifier Name or identifier of role
     *
     * @return self
     */
    public function setRole(string|null $identifier): static;

    /**
     * Get role
     *
     * If no role value set, method
     * sets and returns a default role.
     *
     * @see getDefaultRole()
     *
     * @return string|null role or null if no role has been set
     */
    public function getRole(): string|null;

    /**
     * Check if role has been set
     *
     * @return bool True if role has been set, false if not
     */
    public function hasRole(): bool;

    /**
     * Get a default role value, if any is available
     *
     * @return string|null Default role value or null if no default value is available
     */
    public function getDefaultRole(): string|null;
}
