<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Username Aware
 *
 * Component is aware of string "username"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface UsernameAware
{
    /**
     * Set username
     *
     * @param string|null $identifier Identifier to be used as username
     *
     * @return self
     */
    public function setUsername(string|null $identifier): static;

    /**
     * Get username
     *
     * If no username value set, method
     * sets and returns a default username.
     *
     * @see getDefaultUsername()
     *
     * @return string|null username or null if no username has been set
     */
    public function getUsername(): string|null;

    /**
     * Check if username has been set
     *
     * @return bool True if username has been set, false if not
     */
    public function hasUsername(): bool;

    /**
     * Get a default username value, if any is available
     *
     * @return string|null Default username value or null if no default value is available
     */
    public function getDefaultUsername(): string|null;
}
