<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Logo Aware
 *
 * Component is aware of string "logo"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LogoAware
{
    /**
     * Set logo
     *
     * @param string|null $location Path, Uri or other type of location to a logo
     *
     * @return self
     */
    public function setLogo(string|null $location): static;

    /**
     * Get logo
     *
     * If no logo value set, method
     * sets and returns a default logo.
     *
     * @see getDefaultLogo()
     *
     * @return string|null logo or null if no logo has been set
     */
    public function getLogo(): string|null;

    /**
     * Check if logo has been set
     *
     * @return bool True if logo has been set, false if not
     */
    public function hasLogo(): bool;

    /**
     * Get a default logo value, if any is available
     *
     * @return string|null Default logo value or null if no default value is available
     */
    public function getDefaultLogo(): string|null;
}
