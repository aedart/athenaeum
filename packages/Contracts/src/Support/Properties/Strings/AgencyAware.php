<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Agency Aware
 *
 * Component is aware of string "agency"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AgencyAware
{
    /**
     * Set agency
     *
     * @param string|null $name Name of agency organisation
     *
     * @return self
     */
    public function setAgency(string|null $name): static;

    /**
     * Get agency
     *
     * If no agency value set, method
     * sets and returns a default agency.
     *
     * @see getDefaultAgency()
     *
     * @return string|null agency or null if no agency has been set
     */
    public function getAgency(): string|null;

    /**
     * Check if agency has been set
     *
     * @return bool True if agency has been set, false if not
     */
    public function hasAgency(): bool;

    /**
     * Get a default agency value, if any is available
     *
     * @return string|null Default agency value or null if no default value is available
     */
    public function getDefaultAgency(): string|null;
}
