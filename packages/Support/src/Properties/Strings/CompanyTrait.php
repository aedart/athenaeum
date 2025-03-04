<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Company Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CompanyAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CompanyTrait
{
    /**
     * Name of company
     *
     * @var string|null
     */
    protected string|null $company = null;

    /**
     * Set company
     *
     * @param string|null $name Name of company
     *
     * @return self
     */
    public function setCompany(string|null $name): static
    {
        $this->company = $name;

        return $this;
    }

    /**
     * Get company
     *
     * If no company value set, method
     * sets and returns a default company.
     *
     * @see getDefaultCompany()
     *
     * @return string|null company or null if no company has been set
     */
    public function getCompany(): string|null
    {
        if (!$this->hasCompany()) {
            $this->setCompany($this->getDefaultCompany());
        }
        return $this->company;
    }

    /**
     * Check if company has been set
     *
     * @return bool True if company has been set, false if not
     */
    public function hasCompany(): bool
    {
        return isset($this->company);
    }

    /**
     * Get a default company value, if any is available
     *
     * @return string|null Default company value or null if no default value is available
     */
    public function getDefaultCompany(): string|null
    {
        return null;
    }
}
