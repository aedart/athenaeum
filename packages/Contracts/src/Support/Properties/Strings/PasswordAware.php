<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Password Aware
 *
 * Component is aware of string "password"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PasswordAware
{
    /**
     * Set password
     *
     * @param string|null $password Password
     *
     * @return self
     */
    public function setPassword(string|null $password): static;

    /**
     * Get password
     *
     * If no password value set, method
     * sets and returns a default password.
     *
     * @see getDefaultPassword()
     *
     * @return string|null password or null if no password has been set
     */
    public function getPassword(): string|null;

    /**
     * Check if password has been set
     *
     * @return bool True if password has been set, false if not
     */
    public function hasPassword(): bool;

    /**
     * Get a default password value, if any is available
     *
     * @return string|null Default password value or null if no default value is available
     */
    public function getDefaultPassword(): string|null;
}
