<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Package Aware
 *
 * Component is aware of string "package"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PackageAware
{
    /**
     * Set package
     *
     * @param string|null $name Name of package. Can evt. contain path to package as well
     *
     * @return self
     */
    public function setPackage(string|null $name): static;

    /**
     * Get package
     *
     * If no package value set, method
     * sets and returns a default package.
     *
     * @see getDefaultPackage()
     *
     * @return string|null package or null if no package has been set
     */
    public function getPackage(): string|null;

    /**
     * Check if package has been set
     *
     * @return bool True if package has been set, false if not
     */
    public function hasPackage(): bool;

    /**
     * Get a default package value, if any is available
     *
     * @return string|null Default package value or null if no default value is available
     */
    public function getDefaultPackage(): string|null;
}
