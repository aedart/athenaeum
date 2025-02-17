<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Organisation Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\OrganisationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait OrganisationTrait
{
    /**
     * Name of organisation
     *
     * @var string|null
     */
    protected string|null $organisation = null;

    /**
     * Set organisation
     *
     * @param string|null $name Name of organisation
     *
     * @return self
     */
    public function setOrganisation(string|null $name): static
    {
        $this->organisation = $name;

        return $this;
    }

    /**
     * Get organisation
     *
     * If no organisation value set, method
     * sets and returns a default organisation.
     *
     * @see getDefaultOrganisation()
     *
     * @return string|null organisation or null if no organisation has been set
     */
    public function getOrganisation(): string|null
    {
        if (!$this->hasOrganisation()) {
            $this->setOrganisation($this->getDefaultOrganisation());
        }
        return $this->organisation;
    }

    /**
     * Check if organisation has been set
     *
     * @return bool True if organisation has been set, false if not
     */
    public function hasOrganisation(): bool
    {
        return isset($this->organisation);
    }

    /**
     * Get a default organisation value, if any is available
     *
     * @return string|null Default organisation value or null if no default value is available
     */
    public function getDefaultOrganisation(): string|null
    {
        return null;
    }
}
