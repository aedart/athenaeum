<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Organisation Aware
 *
 * Component is aware of string "organisation"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface OrganisationAware
{
    /**
     * Set organisation
     *
     * @param string|null $name Name of organisation
     *
     * @return self
     */
    public function setOrganisation(?string $name);

    /**
     * Get organisation
     *
     * If no "organisation" value set, method
     * sets and returns a default "organisation".
     *
     * @see getDefaultOrganisation()
     *
     * @return string|null organisation or null if no organisation has been set
     */
    public function getOrganisation(): ?string;

    /**
     * Check if "organisation" has been set
     *
     * @return bool True if "organisation" has been set, false if not
     */
    public function hasOrganisation(): bool;

    /**
     * Get a default "organisation" value, if any is available
     *
     * @return string|null Default "organisation" value or null if no default value is available
     */
    public function getDefaultOrganisation(): ?string;
}
