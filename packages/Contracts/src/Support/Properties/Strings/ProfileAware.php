<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Profile Aware
 *
 * Component is aware of string "profile"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ProfileAware
{
    /**
     * Set profile
     *
     * @param string|null $profile The profile of someone or something
     *
     * @return self
     */
    public function setProfile(string|null $profile): static;

    /**
     * Get profile
     *
     * If no profile value set, method
     * sets and returns a default profile.
     *
     * @see getDefaultProfile()
     *
     * @return string|null profile or null if no profile has been set
     */
    public function getProfile(): string|null;

    /**
     * Check if profile has been set
     *
     * @return bool True if profile has been set, false if not
     */
    public function hasProfile(): bool;

    /**
     * Get a default profile value, if any is available
     *
     * @return string|null Default profile value or null if no default value is available
     */
    public function getDefaultProfile(): string|null;
}
