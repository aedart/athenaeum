<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Agency Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\AgencyAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait AgencyTrait
{
    /**
     * Name of agency organisation
     *
     * @var string|null
     */
    protected string|null $agency = null;

    /**
     * Set agency
     *
     * @param string|null $name Name of agency organisation
     *
     * @return self
     */
    public function setAgency(string|null $name): static
    {
        $this->agency = $name;

        return $this;
    }

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
    public function getAgency(): string|null
    {
        if (!$this->hasAgency()) {
            $this->setAgency($this->getDefaultAgency());
        }
        return $this->agency;
    }

    /**
     * Check if agency has been set
     *
     * @return bool True if agency has been set, false if not
     */
    public function hasAgency(): bool
    {
        return isset($this->agency);
    }

    /**
     * Get a default agency value, if any is available
     *
     * @return string|null Default agency value or null if no default value is available
     */
    public function getDefaultAgency(): string|null
    {
        return null;
    }
}
