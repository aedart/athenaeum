<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Company Aware
 *
 * Component is aware of string "company"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CompanyAware
{
    /**
     * Set company
     *
     * @param string|null $name Name of company
     *
     * @return self
     */
    public function setCompany(string|null $name): static;

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
    public function getCompany(): string|null;

    /**
     * Check if company has been set
     *
     * @return bool True if company has been set, false if not
     */
    public function hasCompany(): bool;

    /**
     * Get a default company value, if any is available
     *
     * @return string|null Default company value or null if no default value is available
     */
    public function getDefaultCompany(): string|null;
}
