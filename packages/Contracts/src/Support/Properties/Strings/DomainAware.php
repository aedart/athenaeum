<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Domain Aware
 *
 * Component is aware of string "domain"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DomainAware
{
    /**
     * Set domain
     *
     * @param string|null $domain Name, URL, territory or term that describes a given domain... etc
     *
     * @return self
     */
    public function setDomain(string|null $domain): static;

    /**
     * Get domain
     *
     * If no domain value set, method
     * sets and returns a default domain.
     *
     * @see getDefaultDomain()
     *
     * @return string|null domain or null if no domain has been set
     */
    public function getDomain(): string|null;

    /**
     * Check if domain has been set
     *
     * @return bool True if domain has been set, false if not
     */
    public function hasDomain(): bool;

    /**
     * Get a default domain value, if any is available
     *
     * @return string|null Default domain value or null if no default value is available
     */
    public function getDefaultDomain(): string|null;
}
