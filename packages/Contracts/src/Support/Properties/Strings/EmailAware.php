<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Email Aware
 *
 * Component is aware of string "email"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface EmailAware
{
    /**
     * Set email
     *
     * @param string|null $email Email
     *
     * @return self
     */
    public function setEmail(string|null $email): static;

    /**
     * Get email
     *
     * If no email value set, method
     * sets and returns a default email.
     *
     * @see getDefaultEmail()
     *
     * @return string|null email or null if no email has been set
     */
    public function getEmail(): string|null;

    /**
     * Check if email has been set
     *
     * @return bool True if email has been set, false if not
     */
    public function hasEmail(): bool;

    /**
     * Get a default email value, if any is available
     *
     * @return string|null Default email value or null if no default value is available
     */
    public function getDefaultEmail(): string|null;
}
