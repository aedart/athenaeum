<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Domain Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DomainAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DomainTrait
{
    /**
     * Name, URL, territory or term that describes a given domain... etc
     *
     * @var string|null
     */
    protected string|null $domain = null;

    /**
     * Set domain
     *
     * @param string|null $domain Name, URL, territory or term that describes a given domain... etc
     *
     * @return self
     */
    public function setDomain(string|null $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

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
    public function getDomain(): string|null
    {
        if (!$this->hasDomain()) {
            $this->setDomain($this->getDefaultDomain());
        }
        return $this->domain;
    }

    /**
     * Check if domain has been set
     *
     * @return bool True if domain has been set, false if not
     */
    public function hasDomain(): bool
    {
        return isset($this->domain);
    }

    /**
     * Get a default domain value, if any is available
     *
     * @return string|null Default domain value or null if no default value is available
     */
    public function getDefaultDomain(): string|null
    {
        return null;
    }
}
